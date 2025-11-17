<?php

declare(strict_types=1);

namespace Khlystou\OtpField\Field;

use MoonShine\UI\Fields\Field;
use Closure;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use Illuminate\Contracts\Support\Renderable;

class Otp extends Field
{
    protected string $view = 'otp-field::otp';

    protected int $length = 6;

    protected bool $masked = false;

    public function __construct(
        Closure|string|null $label = null, 
        ?string $column = null
    ) {
        return parent::__construct($label, $column ?? $label ?? 'otp', null);
    }

    protected function reformatFilledValue(mixed $data): mixed
    {
        return parent::reformatFilledValue($data);
    }

    protected function prepareFill(array $raw = [], ?DataWrapperContract $casted = null, int $index = 0): mixed
    {
        return parent::prepareFill($raw, $casted, $index);
    }

    protected function resolveValue(): mixed
    {
        return $this->toValue();
    }

    protected function resolvePreview(): Renderable|string
    {
        return (string) ($this->toFormattedValue() ?? '');
    }

    protected function resolveOnApply(): ?Closure
    {
        return function (mixed $item): mixed {
            return data_set($item, $this->getColumn(), $this->getRequestValue());
        };
    }

    public function length(int $length): static
    {
        $this->length = value($length);

        return $this;
    }

    public function masked(): static
    {
        $this->masked = true;
        
        return $this;
    }

    protected function viewData(): array
    {
        return [
            'name' => $this->getColumn(),
            'length' => $this->length,
            'masked' => $this->masked,
        ];
    }
}
