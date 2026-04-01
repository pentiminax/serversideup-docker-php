<?php

namespace App\Enum;

enum TaskPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match($this) {
            self::Low => 'Faible',
            self::Medium => 'Moyenne',
            self::High => 'Haute',
        };
    }

    public function colorClass(): string
    {
        return match($this) {
            self::Low => 'bg-emerald-100 text-emerald-700',
            self::Medium => 'bg-amber-100 text-amber-700',
            self::High => 'bg-red-100 text-red-700',
        };
    }

    public function borderClass(): string
    {
        return match($this) {
            self::Low => 'border-l-emerald-400',
            self::Medium => 'border-l-amber-400',
            self::High => 'border-l-red-500',
        };
    }

    public function dotClass(): string
    {
        return match($this) {
            self::Low => 'bg-emerald-400',
            self::Medium => 'bg-amber-400',
            self::High => 'bg-red-500',
        };
    }
}
