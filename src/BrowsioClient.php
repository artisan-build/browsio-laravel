<?php


namespace ArtisanBuild\Browsio;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class BrowsioClient
{
    public string $url = '';
    public string $returnUrl = '';
    public array $options = [];
    public string $device = 'iPad';

    public function __construct()
    {

    }

    public function addOption($key, $value): self
    {
        array_push($this->options, [$key => $value]);
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function device(string $device): self
    {
        $this->device = $device;
        return $this;
    }

    public function hit(): string
    {
        $hit = Str::orderedUuid()->toString();
        $this->returnUrl = route('browsio', ['hit' => $hit]);


        return Http::withToken(config('browsio.token'))->post(config('browsio.url'), [
            'url' => $this->url,
            'returnUrl' => $this->returnUrl,
            'options' => $this->options,
            'device' => $this->device,
            'hit' => $hit,
        ]);
    }


}