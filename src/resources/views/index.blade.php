<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ __('Sent Emails') }}</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">

<header class="flex flex-shrink-0 bg-gray-800">
    <div class="w-full flex-shrink-0 px-4 py-3">
        <span class="ml-4 mr-2 text-sm font-medium text-white">{{ __('Sent Emails') }}</span>
    </div>
</header>

<div class="flex flex-shrink-0">
    <div class="w-full flex-shrink-0 px-4 py-3">

        <form action="">

            <div class="grid grid-cols-5 gap-4">

                <div class="mb-5">
                    <label for="date" class="block text-sm font-medium leading-5 text-gray-700">Date </label>
                    <div class="rounded-md shadow-sm">
                        <input type="date" id="date" name="date" value="{{ request('date') }}" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="from" class="block text-sm font-medium leading-5 text-gray-700">From </label>
                    <div class="rounded-md shadow-sm">
                        <input type="text" id="from" name="from" value="{{ request('from') }}" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="to" class="block text-sm font-medium leading-5 text-gray-700">To </label>
                    <div class="rounded-md shadow-sm">
                        <input type="text" id="to" name="to" value="{{ request('to') }}" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="subject" class="block text-sm font-medium leading-5 text-gray-700">Subject </label>
                    <div class="rounded-md shadow-sm">
                        <input type="text" id="subject" name="subject" value="{{ request('subject') }}" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="">
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center py-1 px-2 border border-transparent text-xs leading-4 font-medium rounded text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">Search Emails</button>
                        <a href="{{ url(config('sentemails.routepath')) }}" class="inline-flex items-center py-1 px-2 border border-transparent text-xs leading-4 font-medium rounded text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">Reset</a>
                    </div>
                </div>

            </div>

        </form>

    </div>
</div>



<div class="flex flex-1 overflow-hidden">

    <main class="flex-1 flex bg-gray-200">

        <div class="relative flex flex-col w-full max-w-xs flex-grow border-l border-r bg-gray-200">
            <div class="flex-1 overflow-y-auto">
                @foreach($emails as $email)
                    @php
                    $parts = explode('<', $email->from);
                    if (isset($parts[1])) {
                        $from = $parts[0];
                    } else {
                        $from = $parts[0];
                    }
                    @endphp
                    <a href="#" class="block px-6 pt-3 pb-4 bg-white emailitem border-b-2" data-id="{{ $email->id }}">
                        <div class="flex justify-between">
                        <span class="text-sm font-semibold text-gray-900">{{ $from }}</span>
                        <span class="text-xs text-gray-500">{{ $email->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-900">{{ $email->subject }}</p>
                        @if(config('sentemails.storeAttachments'))
                            {{ __('Attachments') }}: {{ $email->attachments->count() }}
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex-1 flex flex-col w-0">
            <div id='emailcontent'></div>
        </div>

    </main>

</div>

@if ($emails->count() == 0)
    <div class="m-10 x-5">
        <h2 class="text-2xl">{{ config('sentemails.noEmailsMessage') }}</h2>
    </div>
@endif

{{ $emails->links('sentemails::pagination') }}

<script>
const emailcontent = document.getElementById('emailcontent');
const element = document.querySelectorAll('.emailitem');

//load specific email when clicked
element.forEach(function(el){
    el.addEventListener('click', function ($event) {
        load(el.dataset.id);
    });
});

//load first email if no emails have been clicked
load(element[0].dataset.id);

//load data
function load(id) {
    fetch('{{ url(config('sentemails.routepath').'/email') }}/'+id)
    .then(function(response) {
        return response.text();
    }).then(function(string) {
        emailcontent.innerHTML = string;
    });
}
</script>