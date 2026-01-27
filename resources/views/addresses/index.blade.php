<x-account-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Address Book</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage your billing and shipping addresses.</p>
            </div>
            <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add New Address
            </a>
        </div>
        <div class="border-t border-gray-200">
            @if($addresses->isEmpty())
                <div class="px-4 py-5 sm:p-6 text-center text-gray-500">
                    No addresses found. Add one to get started.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($addresses as $address)
                        <li class="px-4 py-5 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium text-indigo-600 truncate uppercase tracking-wider">
                                            {{ $address->type }}
                                            @if($address->is_default)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                  Default
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-900 font-bold">{{ $address->first_name }} {{ $address->last_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $address->address_line_1 }}</p>
                                        @if($address->address_line_2)
                                            <p class="text-sm text-gray-500">{{ $address->address_line_2 }}</p>
                                        @endif
                                        <p class="text-sm text-gray-500">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                        <p class="text-sm text-gray-500">{{ $address->country }}</p>
                                        @if($address->phone)
                                            <p class="text-sm text-gray-500 mt-1"><span class="font-medium">Phone:</span> {{ $address->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('addresses.edit', $address->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-account-layout>

