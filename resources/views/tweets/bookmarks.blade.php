<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('ブックマーク') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          @if (session('status'))
            <div class="mb-4 rounded bg-green-50 p-3 text-green-700">
              {{ session('status') }}
            </div>
          @endif

          @if ($tweets->isEmpty())
            <p class="text-gray-500">ブックマークはまだありません。</p>
          @else
            <div class="space-y-4">
              @foreach ($tweets as $tweet)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                  <div class="text-sm text-gray-500 dark:text-gray-300">
                    @if($tweet->user ?? null)
                      {{ $tweet->user->name }}・{{ $tweet->created_at->format('Y/m/d H:i') }}
                    @endif
                  </div>
                  <div class="mt-1 whitespace-pre-wrap">{{ $tweet->tweet }}</div>

                  <div class="mt-2 flex gap-4 text-sm">
                    <a href="{{ route('tweets.show', $tweet) }}" class="hover:underline">詳細</a>
                    <form method="POST" action="{{ route('bookmarks.toggle', $tweet) }}">
                      @csrf
                      <button type="submit" class="hover:underline">ブックマークを解除</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="mt-6">{{ $tweets->links() }}</div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
