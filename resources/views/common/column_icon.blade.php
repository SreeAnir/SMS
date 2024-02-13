@if(isset($icon['muted']) && $icon['muted']==0 && !$icon['enabled'])
@else
    {!! getSvgIcon($icon['path'],($icon['enabled']?'svg-icon-primary':'svg-icon-muted ').(isset($icon['class'])?$icon['class']:' svg-icon-3'),'',isset($icon['label'])?$icon['label']:'') !!}
@endif