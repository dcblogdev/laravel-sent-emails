<div class="relative shadow-md">
    <div class="flex items-center justify-between px-5 py-3 bg-white">
        <h3 class="text-xl text-gray-900 truncate">{{ $email->subject }}</h3>
        <div class="ml-4 flex-shrink-0">
            <span>#{{ $email->id }}</span>
        </div>
    </div>
</div>
<div class="p-3 flex-1 overflow-y-auto">

    <article class="px-10 pt-6 pb-8 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <p class="text-lg font-semibold">
                <span class="text-gray-900 text-sm">
                    {{ $email->from }}<br>
                    {{ __('To') }}: {{ $email->to }}<br>
                    @if ($email->cc !=''){{ __('CC') }}: {{ $email->cc }}<br>@endif
                    @if ($email->bcc !=''){{ __('BCC') }}: {{ $email->bcc }}<br>@endif
                    @if (config('sentemails.storeAttachments'))
                        @if ($email->attachments->count() > 0)
                            {{ __('Attachment') }}
                        @endif
                        @foreach($email->attachments as $attachment)
                            <a
                                class="bg-gray-200 px-2 py-1 rounded-lg text-xs text-gray-800 hover:text-gray-900 hover:bg-gray-300"
                                href="{{ route('sentemails.downloadAttachment', $attachment->id) }}">
                                    {{ $attachment->filename }}
                            </a>
                        @endforeach
                    @endif
                </span>
            </p>
            <div class="flex items-center">
                <span class="text-xs text-gray-600">{{ date('F jS Y H:i A', strtotime($email->created_at)) }}</span>
            </div>
        </div>
        <div class="mt-6 text-gray-800 text-sm border-t-2">
            <iframe src="{{ url(config('sentemails.routepath')."/body/$email->id")}}" width="100%" height="600px"></iframe>
        </div>
    </article>

</div>