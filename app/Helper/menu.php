<?php

use App\Models\ApprovalStatus;
use App\Models\Status;
use App\Models\User;
use App\Services\MemoizationService;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

function getSvgIcon(string $path, $iconClass = "", $svgClass = "", $label = "")
{
    $full_path = public_path('assets/media/icons/duotune/').$path;
    if (!file_exists($full_path)) {
        return "<!-- SVG file not found: ".$full_path." -->";
    }

    $svg_content = file_get_contents($full_path);

    $dom = new DOMDocument();
    $dom->loadXML($svg_content);

    // remove unwanted comments
    $xpath = new DOMXPath($dom);
    foreach ($xpath->query("//comment()") as $comment) {
        $comment->parentNode->removeChild($comment);
    }

    // add class to svg
    if (!empty($svgClass)) {
        foreach ($dom->getElementsByTagName("svg") as $element) {
            $element->setAttribute("class", $svgClass);
        }
    }

    // remove unwanted tags
    $title = $dom->getElementsByTagName("title");
    if ($title["length"]) {
        $dom->documentElement->removeChild($title[0]);
    }

    $desc = $dom->getElementsByTagName("desc");
    if ($desc["length"]) {
        $dom->documentElement->removeChild($desc[0]);
    }

    $defs = $dom->getElementsByTagName("defs");
    if ($defs["length"]) {
        $dom->documentElement->removeChild($defs[0]);
    }

    // remove unwanted id attribute in g tag
    $g = $dom->getElementsByTagName("g");
    foreach ($g as $el) {
        $el->removeAttribute("id");
    }

    $mask = $dom->getElementsByTagName("mask");
    foreach ($mask as $el) {
        $el->removeAttribute("id");
    }

    $rect = $dom->getElementsByTagName("rect");
    foreach ($rect as $el) {
        $el->removeAttribute("id");
    }

    $path = $dom->getElementsByTagName("path");
    foreach ($path as $el) {
        $el->removeAttribute("id");
    }

    $circle = $dom->getElementsByTagName("circle");
    foreach ($circle as $el) {
        $el->removeAttribute("id");
    }

    $use = $dom->getElementsByTagName("use");
    foreach ($use as $el) {
        $el->removeAttribute("id");
    }

    $polygon = $dom->getElementsByTagName("polygon");
    foreach ($polygon as $el) {
        $el->removeAttribute("id");
    }

    $ellipse = $dom->getElementsByTagName("ellipse");
    foreach ($ellipse as $el) {
        $el->removeAttribute("id");
    }

    $string = $dom->saveXML($dom->documentElement);

    // remove empty lines
    $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

    $cls = array("svg-icon");

    if (!empty($iconClass)) {
        $cls = array_merge($cls, explode(" ", $iconClass));
    }

    return new HtmlString("<!-- Full Path: ".$full_path." --><span ".($label <> "" ? 'title="'.$label.'"' : '')." class=\"".implode(" ", $cls)."\">".$string."</span>");
}

function isCurrentPath($menu_item)
{
    if (isset($menu_item['active_pattern'])) {
        return request()->routeIs(...(array) $menu_item['active_pattern']);
    }
    if (!isset($menu_item['link']) && isset($menu_item['children']) && count($menu_item['children'])) {
        collect($menu_item['children'])->contains('link', request()->url());
    }
    return request()->url() === ($menu_item['link'] ?? '#');
}

function canShowMenuItem($menu_item)
{
    return MemoizationService::memoized('menu-item-can-'.Str::snake($menu_item['label']), function () use ($menu_item) {
        return !isset($menu_item['can'])
            || (is_callable($menu_item['can']) && $menu_item['can']())
            || (is_array($menu_item['can']) && count(array_filter($menu_item['can'], function ($can) {
                    return is_callable($can) && $can();
                })));
    }, 'menu');
}

function canShowTab($tab)
{
    return MemoizationService::memoized('tab-can-'.Str::snake($tab['label']), function () use ($tab) {
        return isset($tab['components']['menu']) && collect($tab['components']['menu'])->filter(function ($menu_item) {
                return canShowMenuItem($menu_item);
            })->count() > 0;
    }, 'menu');
}

function defaultActions($route_prefix, $instance, array $except = [], $statuses = null): array
{
    /** @var User $user */
    $user = auth()->user();
    $actions = [];
    if (!in_array(SoftDeletes::class, class_uses($instance)) || !$instance->trashed()) {
        if (!in_array('view', $except) && $user->can('view', $instance)) {
            $actions[] = [
                'label' => __('View'),
                'url' => route($route_prefix.'.show', $instance),
                'icon' => 'fas fa-eye',
            ];
        }

        if (!in_array('change_status', $except) && in_array(HasStatus::class, class_uses($instance))
            && $user->can('update', $instance)) {
            $actions[] = [
                'label' => __('Change status'),
                'url' => '#',
                'icon' => $instance->status_id === 1 ? 'fas fa-lock' : 'fas fa-lock-open',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'change_status',
                    'data-statuses' => htmlentities(json_encode($statuses ?? Status::list())),
                    'data-model' => get_class($instance),
                    'data-key' => $instance->getKey(),
                    'data-current' => $instance->status_id,
                ])
            ];
        }

        // if (!in_array('approve_tutor', $except) && in_array(HasStatus::class, class_uses($instance)) && $user->can('changeApprovalStatus', $instance)) {
        //     $actions[] = [
        //         'url' => '#',
        //         'label' => 'Approval Status',
        //         'icon' => 'fas fa-check',
        //         /*'label' => in_array($instance->approval_status_id, [ApprovalStatus::STATUS_TUTOR_REJECTED, ApprovalStatus::STATUS_TUTOR_PENDING])
        //             ? __('Approve Tutor') : __('Reject Tutor'),
        //         'icon' => in_array($instance->approval_status_id, [ApprovalStatus::STATUS_TUTOR_REJECTED, ApprovalStatus::STATUS_TUTOR_PENDING])
        //             ? 'fas fa-check' : 'fas fa-times',*/
        //         'attributes' => new ComponentAttributeBag([
        //             'class' => 'approve_tutor',
        //             'data-statuses' => htmlentities (json_encode( ApprovalStatus::list() )),
        //             'data-model' => get_class($instance),
        //             'data-key' => $instance->getKey(),
        //             'data-current' => $instance->approval_status_id,
        //         ])
        //     ];
        // }

        if (!in_array('edit', $except) && $user->can('update', $instance)) {
            $actions[] = [
                'label' => __('Edit'),
                'url' => route($route_prefix.'.edit', $instance),
                'icon' => 'fas fa-pencil-alt',
            ];
        }
        if (!in_array('delete', $except) && $user->can('delete', $instance)) {
            $actions[] = [
                'label' => __('Delete'),
                'url' => route($route_prefix.'.destroy', $instance),
                'icon' => 'fas fa-trash',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'table_row_delete',
                ])
            ];
        }
    } else {
        if (!in_array('restore', $except) && $user->can('restore', $instance)) {
            $actions[] = [
                'label' => __('Restore'),
                'url' => route($route_prefix.'.restore', $instance),
                'icon' => 'fas fa-window-restore',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'table_row_restore',
                ])
            ];
        }
    }
    return $actions;
}

function formTemplateActions($route_prefix, $instance, array $except = [], $statuses = null)
{
    /** @var User $user */
    $user = auth()->user();
    $actions = [];
    if (!in_array(SoftDeletes::class, class_uses($instance)) || !$instance->trashed()) {
        if (!in_array('view', $except) && $user->can('view', $instance) && !$instance->is_template) {
            $actions[] = [
                'label' => __('View Form'),
                'url' => route('admin.form_templates.show', $instance),
                'icon' => 'fas fa-eye',
                'target' => '_blank'
            ];
        }
        if (!in_array('view', $except) && $user->can('view', $instance) && !$instance->is_template) {
            $actions[] = [
                'label' => __('View submissions'),
                'url' => route('admin.form-submissions.index', ['form' => $instance->identifier]),
                'icon' => 'fas fa-eye',
            ];
        }
        if (!in_array('change_status', $except) && in_array(HasStatus::class, class_uses($instance))
            && $user->can('view', $instance)) {
            $actions[] = [
                'label' => __('Change status'),
                'url' => '#',
                'icon' => $instance->status_id === 1 ? 'fas fa-lock' : 'fas fa-lock-open',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'change_status',
                    'data-statuses' => htmlentities(json_encode($statuses ?? Status::list())),
                    'data-model' => get_class($instance),
                    'data-key' => $instance->getKey(),
                    'data-current' => $instance->status_id,
                ])
            ];
        }
        if (!in_array('edit', $except) && $user->can('view', $instance) && $instance->is_template) {
            $actions[] = [
                'label' => __('Edit'),
                'url' => route($route_prefix.'.edit', $instance),
                'icon' => 'fas fa-pen-nib',
            ];
        }
        if (!in_array('delete', $except) && $user->can('delete', $instance)) {
            $actions[] = [
                'label' => __('Delete'),
                'url' => route($route_prefix.'.destroy', $instance),
                'icon' => 'fas fa-trash',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'table_row_delete',
                ])
            ];
        }
    } else {
        if (!in_array('restore', $except) && $user->can('restore', $instance)) {
            $actions[] = [
                'label' => __('Restore'),
                'url' => route($route_prefix.'.restore', $instance),
                'icon' => 'fas fa-window-restore',
                'attributes' => new ComponentAttributeBag([
                    'class' => 'table_row_restore',
                ])
            ];
        }
    }
    return $actions;
}
