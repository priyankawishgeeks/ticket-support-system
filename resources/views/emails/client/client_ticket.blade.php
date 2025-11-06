@component('mail::message')
# Ticket Created Successfully

Hello {{ $ticket->user->username ?? 'Client' }},

Your ticket has been created successfully. Here are the details:

- **Ticket ID:** {{ $ticket->id }}
- **Title:** {{ $ticket->title }}
- **Status:** {{ $ticket->status }}
- **Created At:** {{ $ticket->created_at->format('d M Y H:i') }}

@component('mail::button', ['url' => url('/tickets/'.$ticket->id)])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
