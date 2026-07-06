@extends('layouts.public')

@section('content')

<section id="beranda">
    @include('profil.sections.hero')
</section>

<section id="tentang">
    @include('profil.sections.tentang')
</section>

<section id="layanan">
    @include('profil.sections.layanan')
</section>

<section id="dokter">
    @include('profil.sections.dokter')
</section>

<section id="gallery">
    @include('profil.sections.galeri')
</section>

<section id="faq">
    @include('profil.sections.faq')
</section>

<section id="kontak">
    @include('profil.sections.kontak')
</section>

@endsection