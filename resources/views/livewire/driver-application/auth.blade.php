<form class="text-center" action="{{ route('driver-application.auth.steam') }}" method="POST">
    @csrf
    <div>
        <h1 class="text-4xl leading-tight font-bold text-gray-900 pb-3">
            Welcome to the Phoenix Recruitment System.
        </h1>
        <h2 class="text-3xl leading-6 font-semibold text-gray-900 pb-5">
            Awesome to hear that you want to join us!
        </h2>
        <hr>
        <div class="inline-flex flex-col items-center prose prose-sm pt-2 pb-5 text-center">
            <h3>Applicant Requirements:</h3>
            <p>
                • Be over 16 years of age
                <br>
                • Have at least 75 hours in ETS2 or ATS (this can be combined between both games)
                <br>
                • Have a TruckersMP account that is at least three months old
                <br>
                • Have no TruckersMP bans within the past three months
                <br>
                • Be willing to log jobs and agree to meet our activity requirement of 1000 km (620 miles) per month
                <br>
                • Must speak English
            </p>
        </div>
    </div>
    <img class="object-contain h-60 w-full pb-5" src="{{ asset('img/illustrations/off_road.svg') }}"
         alt="Off Road Illustration"/>
    <button
        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        type="submit">
        <i class="fab fa-steam fa-fw fa-lg m-auto -ml-1 mr-3"></i>
        Sign in with Steam
    </button>
</form>
