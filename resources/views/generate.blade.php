<?php
?>
@extends('templates.app')
@section('title')
    PHP Generator
@stop

@section('header')
    <div class="max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            PHP Generator
        </h1>
    </div>
@stop

@section('main')
    <div class="px-4 grid lg:grid-cols-2">
        <div class="px-4 flex flex-col text-xs space-y-4">
            <p class="pt-5">This utility will generate PHP getter and setter methods for all the private and protected
                members of a
                class. Simply paste the class into the textbox and click "Generate".</p>
            <p>Inspired by <a href="http://mikeangstadt.name/projects/getter-setter-gen/"
                              class="underline text-green-500">Michael Angstadt's</a>
                original php getter/setter generator. I wanted a little bit more control in what I could generate.
                Obviously if we are not using strings, the code will have to be modified by hand (should be
                significantly less work), as we don't really
                type hint in the declaration of variables (that might change as php becomes more object-oriented) </p>
            <x-form>
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-x-2 gap-y-0">
                            <div class="col-span-6 sm:col-span-4">
                                <x-form-group name="indent_char" label="Indent Character" inline>
                                    <x-form-radio name="indent_char" value="t" label="Tab" default/>
                                    <x-form-radio name="indent_char" value="s" label="Space"/>
                                </x-form-group>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-form-input name="indent_size" label="Indent Size" class="border-2 py-1" default="1"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-form-group name="newline_char" label="Newline Character" inline>
                                    <x-form-radio name="newline_char" value="u" label="Unix" default/>
                                    <x-form-radio name="newline_char" value="w" label="Windows"/>
                                    <x-form-radio name="newline_char" value="n" label="Mac"/>
                                </x-form-group>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-form-group>
                                    <x-form-checkbox name="is_constructor" label="Generate Constructor"/>
                                    <x-form-checkbox name="is_toarray" label="Generate ToArray"/>
                                    <x-form-checkbox name="is_pascalcase" label="Force PascalCase on Functions"/>
                                </x-form-group>
                            </div>
                            <div class="col-span-6 sm:col-span-6">
                                <x-form-textarea name="original" label="PHP Class" rows="10" class="border-2 py-1"
                                                 default="{{$original_code}}"></x-form-textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-button.submit color="green" function="">
                            <x-heroicon-o-code class="mr-1 mt-0.5 h-3 w-3"></x-heroicon-o-code>
                            Generate
                        </x-button.submit>
                    </div>
                </div>
            </x-form>
        </div>
        <div class="px-4 mb-4 flex flex-col text-xs space-y-4">
            @if(!empty($generated_code))
                <hr class="mt-6 lg:hidden"/>
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-x-2 gap-y-0">
                            <div class="col-span-8 sm:col-span-6">
                                <x-form-textarea name="generated_code" label="Generated" rows="33" class="border-2 py-1"
                                                 default="{{$generated_code}}"
                                                 style="white-space:pre-wrap;"></x-form-textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
