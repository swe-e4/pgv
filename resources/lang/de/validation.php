<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Das Feld :attribute muss akzeptiert werden.',
    'active_url' => 'Das Feld :attribute ist keine gültige URL.',
    'after' => 'Das Feld :attribute muss ein Datum später als :date sein.',
    'after_or_equal' => 'Das Feld :attribute muss ein Datum später oder gleich :date sein.',
    'alpha' => 'Das Feld :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das Feld :attribute darf nur Buchstaben, Nummern, Querstriche(-) oder Unterstriche enthalten.',
    'alpha_num' => 'Das Feld :attribute darf nur alphanumerische Zahlen und Zeichen enthalten.',
    'array' => 'Das Feld :attribute muss ein Array sein.',
    'before' => 'Das Feld :attribute muss ein Datum früher als :date sein.',
    'before_or_equal' => 'Das Feld :attribute muss ein Datum früher oder gleich :date sein.',
    'between' => [
        'numeric' => 'Das Feld :attribute muss zwischen :min und :max sein.',
        'file' => 'Das Feld :attribute muss zwischen :min und :max kilobytes groß sein.',
        'string' => 'Das Feld :attribute muss zwischen :min und :max Zeichen lang sein.',
        'array' => 'Das Feld :attribute muss zwischen :min und :max Elemente haben.',
    ],
    'boolean' => 'Das Feld :attribute muss wahr(true) oder falsch(false) sein.',
    'confirmed' => 'Das Feld :attribute stimmt nicht mit der Bestätigung überein.',
    'date' => 'Das Feld :attribute enthält kein gültiges Datum.',
    'date_equals' => 'Das Feld :attribute muss ein Datum gleich :date sein.',
    'date_format' => 'Das Feld :attribute entspricht nicht dem Format: :format.',
    'different' => 'Das Feld :attribute und :other müssen sich unterscheiden.',
    'digits' => 'Das Feld :attribute muss :digits Zahlen haben.',
    'digits_between' => 'Das Feld :attribute muss zwischen :min und :max sein.',
    'dimensions' => 'Das Feld :attribute muss eine gültige Bild-Dimension haben.',
    'distinct' => 'Das Feld :attribute hat einen doppelten Wert.',
    'email' => 'Das Feld :attribute muss eine gültige Email-Adresse sein.',
    'ends_with' => 'Das Feld :attribute muss mit einem der folgenden Werte enden: :values',
    'exists' => 'Das ausgewählte Feld :attribute ist nicht gültig.',
    'file' => 'Das Feld :attribute muss eine Datei sein.',
    'filled' => 'Das Feld :attribute muss einen Wert haben.',
    'gt' => [
        'numeric' => 'Das Feld :attribute muss kleiner sein als :value.',
        'file' => 'Das Feld :attribute muss kleiner als :value kilobytes sein.',
        'string' => 'Das Feld :attribute muss weniger als :value Zeichen haben.',
        'array' => 'Das Feld :attribute muss weniger als :value Elemente haben.',
    ],
    'gte' => [
        'numeric' => 'Das Feld :attribute muss größer oder gleich :value sein.',
        'file' => 'Das Feld :attribute muss größer oder gleich :value kilobytes sein.',
        'string' => 'Das Feld :attribute muss größer oder gleich :value Zeichen haben.',
        'array' => 'Das Feld :attribute muss :value oder mehr Elemente haben.',
    ],
    'image' => 'Das Feld  :attribute muss ein Bild sein.',
    'in' => 'Das Feld  selected :attribute ist nicht gültig.',
    'in_array' => 'Das Feld  :attribute Feld existiert nicht in :other.',
    'integer' => 'Das Feld :attribute muss eine Ganzzahl sein.',
    'ip' => 'Das Feld :attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das Feld :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das Feld :attribute muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das Feld :attribute muss ein gültiger JSON-String sein.',
    'lt' => [
        'numeric' => 'Das Feld :attribute muss kleiner :value sein.',
        'file' => 'Das Feld :attribute muss kleiner als :value kilobytes sein.',
        'string' => 'Das Feld :attribute muss weniger als :value Zeichen haben.',
        'array' => 'Das Feld :attribute muss weniger als :value Elemente haben.',
    ],
    'lte' => [
        'numeric' => 'Das Feld :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Das Feld :attribute muss kleiner oder gleich als :value kilobytes sein.',
        'string' => 'Das Feld :attribute muss weniger oder gleich :value Zeichen haben.',
        'array' => 'Das Feld :attribute muss weniger oder gleich :value Elemente haben.',
    ],
    'max' => [
        'numeric' => 'Das Feld :attribute darf nicht größer als :max sein.',
        'file' => 'Das Feld :attribute darf nicht größer als :max kilobytes sein.',
        'string' => 'Das Feld :attribute darf nicht mehr als :max Zeichen haben.',
        'array' => 'Das Feld :attribute darf nicht mehr als :max Elemente haben.',
    ],
    'mimes' => 'Das Feld :attribute muss eine Datei vom Typ: :values sein.',
    'mimetypes' => 'Das Feld :attribute muss eine Datei vom Typ: :values sein.',
    'min' => [
        'numeric' => 'Das Feld :attribute muss mindestens :min sein.',
        'file' => 'Das Feld :attribute muss mindestens :min kilobytes sein.',
        'string' => 'Das Feld :attribute muss mindestens :min Zeichen haben',
        'array' => 'Das Feld :attribute muss mindestens :min Elemente haben.',
    ],
    'not_in' => 'Das ausgewählte Feld :attribute ist nicht gültig.',
    'not_regex' => 'Das Format im Feld :attribute ist nicht gültig.',
    'numeric' => 'Das Feld :attribute muss eine Zahl sein.',
    'password' => 'Das Feld password ist nicht korrekt.',
    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'regex' => 'Das Feld :attribute Format ist nicht gültig.',
    'required' => 'Das Feld :attribute ist erforderlich.',
    'required_if' => 'Das Feld :attribute ist erforderlich wenn :other gleich :value ist.',
    'required_unless' => 'Das Feld :attribute ist erforderlich, wenn :other nicht in :values ist.',
    'required_with' => 'Das Feld :attribute ist erforderlich wenn :values nicht vorhanden ist.',
    'required_with_all' => 'Das Feld :attribute ist erforderlich wenn :values nicht vorhanden ist.',
    'required_without' => 'Das Feld :attribute ist erforderlich wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute ist erforderlich wenn keine von: :values vorhanden sind.',
    'same' => 'Das Feld :attribute und :other müssen gleich sein.',
    'size' => [
        'numeric' => 'Das Feld :attribute muss die Größe :size.',
        'file' => 'Das Feld :attribute muss die Größe :size kilobytes sein.',
        'string' => 'Das Feld :attribute muss die Größe :size Zeichen sein.',
        'array' => 'Das Feld :attribute muss :size Elemente haben.',
    ],
    'starts_with' => 'Das Feld :attribute muss mit einer der Folgenden starten: :values',
    'string' => 'Das Feld :attribute muss ein String sein.',
    'timezone' => 'Das Feld :attribute mmuss eine gültige (Zeit-)Zone sein.',
    'unique' => 'Das Feld :attribute wurde schon ausgewählt.',
    'uploaded' => 'Das Feld :attribute konnte nicht hochgeladen werden.',
    'url' => 'Das Feld Format :attribute ist nicht gültig.',
    'uuid' => 'Das Feld :attribute muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
		'surname' => "Nachname",
		'first_name' => "Vorname",
		'email' => "E-Mail",
		'name' => "Name",
	],

];
