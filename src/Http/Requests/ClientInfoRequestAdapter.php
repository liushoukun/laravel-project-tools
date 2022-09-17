<?php

namespace Liushoukun\LaravelProjectTools\Http\Requests;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Liushoukun\LaravelProjectTools\Contracts\ClientInfo;

/**
 * 客户端信息request适配器
 */
class ClientInfoRequestAdapter implements ClientInfo, Arrayable
{
    /**
     *
     * @var Request
     */
    protected Request $request;

    /**
     *
     * @var Agent
     */
    protected Agent $agent;

    /**
     * @param Request|null $request
     */
    public function __construct(?Request $request = null)
    {
        $agent = new Agent();

        $this->request = $request ?? \request();
        // 设置属性
        $agent->setHttpHeaders($this->request->headers);
        $agent->setUserAgent($this->request->userAgent());
        $this->agent = $agent;
    }

    /**
     * @inheritDoc
     */
    public function userAgent() : ?string
    {
        return $this->request->userAgent();
    }

    /**
     * @param Request|null $request
     * @return ClientInfoRequestAdapter
     */
    public static function make(?Request $request = null) : ClientInfoRequestAdapter
    {
        return new self($request);
    }

    /**
     * @inheritDoc
     */
    public function ip() : ?string
    {
        return $this->request->getClientIp();
    }

    /**
     * @inheritDoc
     */
    public function platform() : ?string
    {
        return $this->agent->platform();
    }

    /**
     * @inheritDoc
     */
    public function device() : ?string
    {
        return $this->agent->device();
    }

    /**
     * @inheritDoc
     */
    public function browser() : ?string
    {
        return $this->agent->browser();
    }

    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * @return Agent
     */
    public function getAgent() : Agent
    {
        return $this->agent;
    }


    /**
     * @inheritDoc
     */
    public function toArray() : array
    {
        return [
            'ip'         => $this->ip(),
            'user-agent' => $this->userAgent(),
            'browser'    => $this->browser(),
            'platform'   => $this->platform(),
            'device'     => $this->device(),
        ];

    }


}
