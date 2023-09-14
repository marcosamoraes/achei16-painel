<main class="flex flex-col items-center flex-1 px-4 pt-32 sm:pt-6 sm:justify-center">
    <div>
        <a href="/">
            <x-application-logo class="w-full h-20" />

            <div class="flex w-full justify-center">
                <x-google-partner-img class="h-24" />
            </div>
        </a>
    </div>

    <div class="w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-md sm:max-w-md dark:bg-dark-eval-1">
        {{ $slot }}
    </div>
</main>
