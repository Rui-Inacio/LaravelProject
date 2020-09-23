@extends('master')

    <header style="background-color: #262525;">
        <span class="words">
            <a class="home" href="/">
                <h2 style="padding-left: 20px;">FlightClub</h2>
            </a>

        </span>
        <span class="words">
            <a class="home" href="/socios">
                Sócios
            </a> &nbsp&nbsp&nbsp
        </span>
        <span class="words">
            <a class="home" href="/aeronaves">
                Aeronaves
            </a> &nbsp&nbsp&nbsp
        </span>
        <span class="words">
            <a class="home" href="/movimentos">
                Movimentos
            </a> &nbsp&nbsp&nbsp
        </span>
        <span style="float: right; padding-bottom: 100px; padding-left: 100px;">
            <a class="home" href="/logout">

                <img width="50px" height="50px" 
                    src="{{asset('storage/fotos/' . auth()->user()->foto_url)}}" 
                        class="img-thumbnail" name="image"/>
            </a>
            <br>
            <a style="padding-right: 10px;" class="words" href="/logout">Logout</a>
        </span>
    </header>

    <style>

    .words{
        padding-left: 30px;
    }

    .home{
        color: red;
    }

    </style>

@yield('section')