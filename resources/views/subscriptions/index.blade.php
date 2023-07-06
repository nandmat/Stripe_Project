<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('subscriptions.store') }}" method="post" id="form">
                        @csrf

                        <div id="show-errors" style="display: none;" class="mt-2 text-sm text-red-600"></div>

                        <p>Plano: {{ $plan->name }}</p>
                        {{-- <input type="hidden" name="stripe_id" value="{{ $plan->stripe_id }}"> --}}

                        <div class="col-span-6 sm:col-span-4 py-2">
                            <input type="text" name="card-holder-name" id="card-holder-name"
                                placeholder="Nome no cartão"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </div>
                        <div class="col-span-6 sm:col-span-4 py-2">
                            <div id="card-element"></div>
                        </div>

                        <div class="col-span-6 sm:col-span-4 py-2">
                            <button id="card-buttom" data-secret="{{ $intent->client_secret }}" type="submit"
                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                Enviar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const stripe = Stripe("{{ config('cashier.key') }}");
    const elements = stripe.elements();

    const cardELement = elements.create('card');
    cardELement.mount('#card-element');

    //subscription payment

    const form = document.getElementById('form')
    const cardHolderName = document.getElementById('card-holder-name')
    const cardButton = document.getElementById('card-buttom')
    const clientSecret = cardButton.dataset.secret
    const showErrors = document.getElementById('show-errors')


    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Disable button
        cardButton.classList.add('cursor-not-allowed')
        cardButton.firstChild.data = 'Validando'

        // reset errors
        showErrors.innerText = ''
        showErrors.style.display = 'none'



        const {
            setupIntent,
            error
        } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardELement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }

        );

        if (error) {
            console.log(error);

            showErrors.style.display = 'block';
            showErrors.innerText = (error.type == 'validation_error') ? error.message : 'Dados Inválidos, verifique e tente novamente';

            cardButton.classList.remove('cursor-not-allowed');
            cardButton.firstChild.data = 'Enviar'

            return;
        }

        let token = document.createElement('input');
        token.setAttribute('type', 'hidden');
        token.setAttribute('name', 'token');
        token.setAttribute('value', setupIntent.payment_method);

        form.appendChild(token);

        form.submit();
    });
</script>
