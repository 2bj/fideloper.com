<?php namespace Fideloper\Storage\Tag;

interface TagInterface {

    public function getPopular($limit=8);

    public function getEtag();
}