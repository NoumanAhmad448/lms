<form action="{{ route('property.index') }}" method="GET" class="flex justify-between"
    style="font-family: 'Nunito', sans-serif;">
    <div class="flex flex-1 justify-between items-center">
        <div class="flex flex-col mx-3">
            <label for="sale">{{ __('lms::Rent') }}/{{ __('lms::Sale') }}</label>
            <select id="sale" name="sale" class="border-0 focus:ring-0">
                <option value="">{{ __('lms::Rent') }}/{{ __('lms::Sale') }}</option>
                <option {{ request('sale') == '2' ? 'selected="selected"' : '' }} value="2">{{ __('lms::Rent') }}
                </option>
                <option {{ request('sale') == '1' ? 'selected="selected"' : '' }} value="1">{{ __('lms::Sale') }}
                </option>
            </select>
        </div>

        <div class="py-3 self-center border-gray-500 border"></div>
        <div class="flex flex-col mx-3">
            <label for="location">{{ __('lms::Location') }}</label>
            <select id="location" name="location" class="border-0 focus:ring-0">
                <option value="">{{ __('lms::Location') }}</option>
                @foreach ($locations as $location)
                    <option class="noTranslate" {{ request('location') == $location->id ? 'selected="selected"' : '' }}
                        value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="py-3 self-center border-gray-500 border"></div>
        <div class="flex flex-col mx-3">
            <label for="type">{{ __('lms::Type') }}</label>
            <select id="type" name="type" class="border-0 focus:ring-0">
                <option value="">{{ __('lms::Type') }}</option>
                <option {{ request('type') == '3' ? 'selected="selected"' : '' }} value="3">{{ __('lms::Land') }}
                </option>
                <option {{ request('type') == '1' ? 'selected="selected"' : '' }} value="1">
                    {{ __('lms::Apartment') }}</option>
                <option {{ request('type') == '2' ? 'selected="selected"' : '' }} value="2">
                    {{ __('lms::Villa') }}</option>
            </select>
        </div>
        <div class="py-3 self-center border-gray-500 border"></div>
        <div class="flex flex-col mx-3">
            <label for="price">{{ __('lms::Price') }}</label>
            <select id="price" name="price" class="border-0 focus:ring-0">
                <option value="">{{ __('lms::Price') }}</option>
                <option {{ request('price') == '100000' ? 'selected="selected"' : '' }} value="100000">0 - 100000
                </option>
                <option {{ request('price') == '200000' ? 'selected="selected"' : '' }} value="200000">100000 - 200000
                    {{ __('lms::Tk') }}</option>
                <option {{ request('price') == '300000' ? 'selected="selected"' : '' }} value="300000">200000 - 300000
                    {{ __('lms::Tk') }}</option>
                <option {{ request('price') == '400000' ? 'selected="selected"' : '' }} value="400000">300000 - 400000
                    {{ __('lms::Tk') }}</option>
                <option {{ request('price') == '500000' ? 'selected="selected"' : '' }} value="500000">400000 - 500000
                    {{ __('lms::Tk') }}</option>
                <option {{ request('price') == '500000+' ? 'selected="selected"' : '' }} value="500000+">500000 up
                    {{ __('lms::Tk') }}</option>
            </select>
        </div>
        <div class="py-3 self-center border-gray-500 border"></div>
        <div class="flex flex-col mx-3">
            <label for="bedrooms">{{ __('lms::Bedrooms') }}</label>
            <select id="bedrooms" name="bedrooms" class="border-0 focus:ring-0">
                <option value="">{{ __('lms::Bedrooms') }}</option>
                <option {{ request('bedrooms') == '1' ? 'selected="selected"' : '' }} value="1">1</option>
                <option {{ request('bedrooms') == '2' ? 'selected="selected"' : '' }} value="2">2</option>
                <option {{ request('bedrooms') == '3' ? 'selected="selected"' : '' }} value="3">3</option>
                <option {{ request('bedrooms') == '4' ? 'selected="selected"' : '' }} value="4">4</option>
                <option {{ request('bedrooms') == '5' ? 'selected="selected"' : '' }} value="5">5</option>
                <option {{ request('bedrooms') == '6' ? 'selected="selected"' : '' }} value="6">6</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between items-end flex-1 ml-5">
        <input name="property_name" value="{{ request('property_name') }}" type="search"
            placeholder="{{ __('lms::Search here') }}"
            class="rounded-lg px-2 py-2 w-full mr-4 focus:border-gray-700 focus:ring-0">
        <button type="submit" class="btn">{{ __('lms::Search') }}</button>
    </div>
</form>
