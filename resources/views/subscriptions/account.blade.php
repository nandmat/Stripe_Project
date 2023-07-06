<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Assinatura') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($subscription)
                        <p>
                            <strong>Plano:</strong>
                            {{ $user->plan()->name }}
                        </p>
                        <br>
                        @if ($subscription->canceled() && $subscription->onGracePeriod())
                            <a href="{{ route('subscriptions.resume') }}"
                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                Reativar Assinatura
                            </a>

                            Seu acesso vai até: {{ $user->access_end }}
                        @elseif (!$subscription->canceled())
                            <a href="{{ route('subscriptions.cancel') }}"
                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                Cancelar Assinatura
                            </a>
                        @endif

                        @if ($subscription->ended())
                            Assinatura Cancelada
                        @endif
                    @else
                        [Não é assinante]
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Data
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Preço
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Download
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                            {{ $invoice->date()->toFormattedDateString() }}
                                        </th>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $invoice->total() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('subscriptions.invoice.download', $invoice->id) }}"
                                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Download</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
