<?php

namespace App\Enum;

enum TaskStatus: string
{
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';

    public function label(): string
    {
        return match($this) {
            self::Todo => 'À faire',
            self::InProgress => 'En cours',
            self::Done => 'Terminé',
        };
    }

    public function colorClass(): string
    {
        return match($this) {
            self::Todo => 'bg-slate-100 text-slate-700',
            self::InProgress => 'bg-blue-100 text-blue-700',
            self::Done => 'bg-green-100 text-green-700',
        };
    }

    public function dotClass(): string
    {
        return match($this) {
            self::Todo => 'bg-slate-400',
            self::InProgress => 'bg-blue-500',
            self::Done => 'bg-green-500',
        };
    }
}
