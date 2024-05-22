<?php

/**
 * Description of 405
 *
 * @author Ansel Melly <ansel@anselmelly.com> @anselmelly
 * @date May 22, 2024
 * @link https://anselmelly.com
 */
?>
@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')

 {!! _($exception->getMessage() ?: 'Forbidden') !!}
 

@endsection