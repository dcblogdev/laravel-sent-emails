<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ __('Sent Emails') }}</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<header class="flex flex-shrink-0 bg-gray-800">
    <div class="w-64 flex-shrink-0 px-4 py-3">
        <span class="ml-4 mr-2 text-sm font-medium text-white">{{ __('Sent Emails') }}</span>
    </div>
</header>
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
                    </a>
                @endforeach 
            </div>
        </div>

        <div class="flex-1 flex flex-col w-0">
            <div id='emailcontent'></div>            
        </div>

    </main>
</div>

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