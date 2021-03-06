<?php

namespace App\Notifications;

use App\Models\Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessage extends Notification
{
    use Queueable;

    public $iid;
    public $email;
    public $sender_name;
    public $chat_id;
    public $name;
    public $CHID;

    public function __construct($name, $iid, $email, $sender_name, $chat_id)
    {
        $this->iid = $iid;
        $this->email = $email;
        $this->sender_name = $sender_name;
        $this->chat_id = $chat_id;
        $this->name = $name;
        $ewwe = Chat::where('id', '=', $this->chat_id)->first();
        $this->CHID = $ewwe->request_id;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {

        $urls = url('https://findme-ui.netlify.app/dashboard/chats/' . $this->CHID);
        return (new MailMessage)
            ->subject(' Your Have New Message')
            ->line('Hi ' . $this->name . ' Your Have New Message')
            ->line($this->sender_name . ' Send Message TO You')
            ->line('You Can Check It')
            ->action('Go To Your DashBoard', url($urls))
            ->line('Thank you for using our application!');

    }

    public function toArray($notifiable)
    {

        return [
            'body' => 'You New Message From ' . $this->sender_name,
            'chat_id' => $this->CHID
        ];
    }
}
