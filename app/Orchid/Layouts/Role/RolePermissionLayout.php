<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use App\Models\User;
use Illuminate\Support\Collection;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\ViewField;
use Orchid\Screen\Layouts\Rows;
use Throwable;

class RolePermissionLayout extends Rows
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * The screen's layout elements.
     *
     *
     * @return Field[]
     *
     * @throws Throwable
     */
    public function fields(): array
    {
        $this->user = $this->query->get('user');

        return $this->generatedPermissionFields(
            $this->query->getContent('permission')
        );
    }

    private function generatedPermissionFields(Collection $permissionsRaw): array
    {
        return $permissionsRaw
            ->map(fn (Collection $permissions, $title) => $this->makeCheckBoxGroup($permissions, $title))
            ->flatten()
            ->toArray();
    }

    private function makeCheckBoxGroup(Collection $permissions, string $title): Collection
    {
        $checkboxes = $permissions
            ->map(fn (array $chunks) => $this->makeCheckBox(collect($chunks)))
            ->flatten()
            ->map(fn (CheckBox $checkbox): string => (string) $checkbox);

        return collect([
            ViewField::make('permission-group-'.md5($title))
                ->view('orchid.permission-group')
                ->set('title', $title)
                ->set('checkboxes', $checkboxes->all()),
        ]);
    }

    private function makeCheckBox(Collection $chunks): CheckBox
    {
        return CheckBox::make('permissions.'.base64_encode($chunks->get('slug')))
            ->placeholder($chunks->get('description'))
            ->value($chunks->get('active'))
            ->sendTrueOrFalse()
            ->indeterminate($this->getIndeterminateStatus(
                $chunks->get('slug'),
                $chunks->get('active')
            ));
    }

    private function getIndeterminateStatus($slug, $value): bool
    {
        return optional($this->user)->hasAccess($slug) === true && $value === false;
    }
}
