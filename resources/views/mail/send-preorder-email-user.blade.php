@if ($webinar->is_preorder && !empty($webinar->message_preorder))
{!! $webinar->message_preorder !!}
@else
{!! $defaultMessage !!}
@endif

