<?php

namespace App;

use Carbon\Carbon;

class DocumentReviewCycle
{
    public static function revisionDate($revisionDate, $docrev = null)
    {
        // DOCREV is authoritative when valid; REVISION_DATE remains a legacy fallback.
        if (self::hasDocrevDate($docrev)) {
            return self::docrevDate($docrev);
        }
        return self::dateValue($revisionDate);
    }

    private static function hasDocrevDate($docrev)
    {
        return is_string($docrev)
            && preg_match('/\(\d{2}[.-]\d{2}[.-]\d{4}\)\s*$/', trim($docrev));
    }

    public static function docrevDate($docrev)
    {
        if (!is_string($docrev) || !preg_match('/\((\d{2})([.-])(\d{2})\2(\d{4})\)\s*$/', trim($docrev), $matches)) {
            return null;
        }
        $day = (int) $matches[1];
        $month = (int) $matches[3];
        $year = (int) $matches[4];
        return checkdate($month, $day, $year)
            ? Carbon::createFromDate($year, $month, $day)->startOfDay()
            : null;
    }

    public static function baseDate($revisionDate, $reviewedAt, $docrev = null)
    {
        if ($reviewedAt === null || $reviewedAt === '') {
            return self::revisionDate($revisionDate, $docrev);
        }

        $reviewDate = self::dateValue($reviewedAt);
        $revision = self::revisionDate($revisionDate, $docrev);

        return $revision && $revision->gt($reviewDate) ? $revision : $reviewDate;
    }

    public static function nextReviewDate($revisionDate, $reviewedAt, $docrev = null)
    {
        $baseDate = self::baseDate($revisionDate, $reviewedAt, $docrev);

        if (!$baseDate) {
            return null;
        }

        $nextYear = (int) $baseDate->format('Y') + 1;
        if ($baseDate->format('m-d') === '02-29' && !checkdate(2, 29, $nextYear)) {
            return $baseDate->copy()->setDate($nextYear, 2, 28)->startOfDay();
        }

        return $baseDate->copy()->addYear()->startOfDay();
    }

    public static function isDue($revisionDate, $reviewedAt, Carbon $today = null, $docrev = null)
    {
        $nextReviewDate = self::nextReviewDate($revisionDate, $reviewedAt, $docrev);

        return $nextReviewDate !== null
            && $nextReviewDate->lte($today ? $today->copy()->startOfDay() : Carbon::today());
    }

    public static function hasCurrentReview($revisionDate, $reviewedAt, $docrev = null)
    {
        if ($reviewedAt === null || $reviewedAt === '') {
            return false;
        }

        $reviewDate = self::dateValue($reviewedAt);
        $revision = self::revisionDate($revisionDate, $docrev);

        return !$revision || $revision->lte($reviewDate);
    }

    public static function cycleKey($revisionDate, $reviewedAt, $docrev = null)
    {
        if ($reviewedAt === null || $reviewedAt === '') {
            $revision = self::revisionDate($revisionDate, $docrev);

            return $revision ? 'revision:'.$revision->format('Y-m-d') : null;
        }

        $reviewDate = Carbon::parse($reviewedAt);
        $revision = self::revisionDate($revisionDate, $docrev);
        if ($revision && $revision->gt($reviewDate->copy()->startOfDay())) {
            return 'revision:'.$revision->format('Y-m-d');
        }

        return 'review:'.$reviewDate->format('Y-m-d H:i:s');
    }

    public static function revisionDateExpression($driver)
    {
        if ($driver === 'sqlite') {
            $inside = "substr(DOCREV, instr(DOCREV, '(') + 1, 10)";
            $parsed = "substr(".$inside.", 7, 4) || '-' || substr(".$inside.", 4, 2) || '-' || substr(".$inside.", 1, 2)";
            $shape = "(DOCREV GLOB '* ([0-3][0-9]-[01][0-9]-[0-9][0-9][0-9][0-9])' OR DOCREV GLOB '* ([0-3][0-9].[01][0-9].[0-9][0-9][0-9][0-9])')";
            $valid = $shape." AND strftime('%d-%m-%Y', ".$parsed.") = replace(".$inside.", '.', '-')";
            return 'CASE WHEN '.$valid.' THEN DATE('.$parsed.') WHEN '.$shape.' THEN NULL WHEN REVISION_DATE IS NOT NULL THEN DATE(REVISION_DATE) END';
        }
        $inside = "SUBSTRING_INDEX(SUBSTRING_INDEX(DOCREV, '(', -1), ')', 1)";
        $parsed = "STR_TO_DATE(REPLACE(".$inside.", '.', '-'), '%d-%m-%Y')";
        $valid = "DATE_FORMAT(".$parsed.", '%d-%m-%Y') = REPLACE(".$inside.", '.', '-')"
            .' AND DAY('.$parsed.') = CAST(SUBSTRING('.$inside.', 1, 2) AS UNSIGNED)'
            .' AND MONTH('.$parsed.') = CAST(SUBSTRING('.$inside.', 4, 2) AS UNSIGNED)';
        $shape = "DOCREV REGEXP '\\([0-9]{2}[.-][0-9]{2}[.-][0-9]{4}\\)$'";
        return 'CASE WHEN '.$valid.' THEN DATE('.$parsed.') WHEN '.$shape.' THEN NULL WHEN REVISION_DATE IS NOT NULL THEN DATE(REVISION_DATE) END';
    }

    public static function baseDateExpression($driver)
    {
        $revisionDate = '('.self::revisionDateExpression($driver).')';

        return 'CASE WHEN REVIEWED_AT IS NULL OR ('.$revisionDate.' IS NOT NULL AND '.$revisionDate.' > DATE(REVIEWED_AT))'
            .' THEN '.$revisionDate.' ELSE DATE(REVIEWED_AT) END';
    }

    public static function nextReviewDateExpression($driver)
    {
        $baseDate = '('.self::baseDateExpression($driver).')';

        if ($driver === 'sqlite') {
            $nextYear = "DATE(".$baseDate.", '+1 year')";

            return "CASE WHEN strftime('%m-%d', ".$baseDate.") = '02-29'"
                ." AND strftime('%m-%d', ".$nextYear.") = '03-01'"
                .' THEN DATE('.$baseDate.", '+1 year', '-1 day') ELSE ".$nextYear.' END';
        }

        return 'DATE(DATE_ADD('.$baseDate.', INTERVAL 1 YEAR))';
    }

    public static function reviewedForCurrentRevisionExpression($driver = 'mysql')
    {
        $revisionDate = '('.self::revisionDateExpression($driver).')';

        return 'CASE WHEN REVIEWED_AT IS NOT NULL AND ('.$revisionDate.' IS NULL OR '.$revisionDate.' <= DATE(REVIEWED_AT)) THEN 1 ELSE 0 END';
    }

    private static function dateValue($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->startOfDay();
        }
        if (is_string($value) && preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:\s|$)/', $value, $matches)) {
            return checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])
                ? Carbon::createFromDate((int) $matches[1], (int) $matches[2], (int) $matches[3])->startOfDay()
                : null;
        }
        return null;
    }
}
