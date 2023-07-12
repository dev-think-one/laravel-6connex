<?php


namespace LaravelSixConnex;

interface CallBody
{
    const TYPE_READ    = 'read';
    const TYPE_READALL = 'readall';
    const TYPE_CREATE  = 'create';
    const TYPE_UPDATE  = 'update';
    const TYPE_DELETE  = 'delete';

    public function addOption($key, $value = null): CallBody;

    public function setApiCall(string $type = 'read'): CallBody;

    public function overrideOptions(array $options): CallBody;

    public function getCallBody(): array;
}
