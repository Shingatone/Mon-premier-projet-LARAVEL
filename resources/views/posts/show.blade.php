<x-layout :title="$post->title">
    <div class="space-y-10 md:space-y-16">
        {{-- <x-post :post="$post" list /> équivalent à  <x-post :$post list /> --}}        
        <x-post :$post />
    </div>            
</x-layout>