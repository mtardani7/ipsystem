<?php

namespace App;

use Carbon\Carbon;

class DocumentReviewCycle
{
    public static function revisionDate($revisionDate, $docrev = null)
    {
        if ($revisionDate !== null && $revisionDate !== '') {
            return self::dateValue($revisionDate);
        }
        if (!is_string($docrev) || !preg_match('/\((\d{2})-(\d{2})-(\d{4})\)$/', trim($docrev), $matches)) {
            return null;
        }

        $day = (int) $matches[1];
        $month = (int) $matches[2];
        $year = (int) $matches[3];
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
            $parsed = "substr(DOCREV, instr(DOCREV, '(') + 7, 4) || '-'"
                ." || substr(DOCREV, instr(DOCREV, '(') + 4, 2) || '-'"
                ." || substr(DOCREV, instr(DOCREV, '(') + 1, 2)";

            return "CASE WHEN REVISION_DATE IS NOT NULL THEN DATE(REVISION_DATE)"
                ." WHEN DOCREV GLOB '* ([0-3][0-9]-[01][0-9]-[0-9][0-9][0-9][0-9])'"
                .' THEN DATE('.$parsed.') END';
        }

        return "CASE WHEN REVISION_DATE IS NOT NULL THEN DATE(REVISION_DATE)"
            ." ELSE STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(DOCREV, '(', -1), ')', 1), '%d-%m-%Y') END";
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
        return $value === null || $value === '' ? null : Carbon::parse($value)->startOfDay();
    }
}
