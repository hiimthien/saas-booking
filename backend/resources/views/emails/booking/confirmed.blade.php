<x-mail::message>
# Consultation Confirmed!

Hello,

A new consultation has been successfully confirmed. Here are the details:

- **Consultant:** {{ $consultation->provider->name }}
- **Client:** {{ $consultation->client->name }}
- **Date & Time:** {{ \Carbon\Carbon::parse($consultation->scheduled_at)->format('F j, Y - g:i A') }}
- **Duration:** {{ $consultation->duration }} minutes
- **Status:** {{ ucfirst($consultation->status) }}

<x-mail::panel>
**Meeting Link:**  
[Join Meeting Here]({{ $consultation->meeting_link }})
</x-mail::panel>

<x-mail::button :url="config('app.frontend_url') . '/' . ($role === 'client' ? 'client' : 'provider') . '/dashboard'">
View Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
