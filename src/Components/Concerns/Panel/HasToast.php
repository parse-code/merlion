<?php

namespace Merlion\Components\Concerns\Panel;

trait HasToast
{
    public function toast($message, $type = 'info', $position = 'center'): static
    {
        session()->flash('toast', [
            'message'  => $message,
            'type'     => $type,
            'position' => $position,
        ]);
        return $this;
    }

    public function success($message): static
    {
        return $this->toast($message, 'success');
    }

    public function danger($message): static
    {
        return $this->toast($message, 'danger');
    }

    public function getMessage()
    {
        return session()->get('toast.message');
    }

    public function getAlert()
    {
        return session()->get('alert.content');
    }

    public function alert($content, $type = 'success'): static
    {
        session()->flash('alert', [
            'content' => $content,
            'type'    => $type,
        ]);
        return $this;
    }
}
