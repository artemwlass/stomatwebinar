@if (!$webinar->is_preorder && !empty($webinar->message_order))
{!! $webinar->message_order !!}
@else
{!! $defaultMessage !!}
@endif
