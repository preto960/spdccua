<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ObsceneWords implements Rule
{
    protected $obsceneWords = [
        "coño",
        "verga",
        "mierda",
        "carajo",
        "pajuo",
        "mamaguevo",
        "maldito",
        "malparido",
        "cabrón",
        "huevón",
        "culicagao",
        "marico",
        "jodido",
        "pinche",
        "guevón",
        "chimbón",
        "chimbo",
        "coñazo",
        "verguero",
        "huevona",
        "pendejo",
        "pendeja",
        "zorra",
        "hijueputa",
        "hijueputo",
        "maricón",
        "bicho",
        "bichote",
        "pichón",
        "guarango",
        "gilipollas",
        "güey",
        "caga",
        "güeyón",
        "verguero",
        "c0ñ0",      
        "v3rga",     
        "m1erda",    
        "c4r4jo",    
        "p4juo",     
        "m4maguevo", 
        "malp4rido", 
        "ch1mb0",    
        "ch1mbón",   
        "v3rgón",    
        "m4rico",    
        "c0ñ4",      
        "v3rg4",     
        "m1erda",    
        "c4r4jo",    
        "h1jueputa", 
        "jueputa",   
        "pichurri",  
        "frescolito",
        "huevonada", 
        "mamarracho",
        "rebusna",   
        "mandrágora",
        "vaina",     
        "vaina e' mierda",
        "que ladilla",
        "pelo e' verga",
        "m3rd4",      
        "huev3n",     
        "c0ñ0r",      
        "jod3r",      
        "mam3r",      
        "mar1co",
        "coñazo",     
        "zorrón",     
        "mamador",    
        "bachaquero",  
        "pendejadas",  
        "jodeverga",   
        "comemierda",  
        "soplón",      
        "bichera",     
        "cachón",      
        "marigüero",   
        "güevonada",   
        "pajua",       
        "pendejito",   
        "mequetrefe",  
        "frescolino",  
        "suciopato",   
        "mamarracho",  
        "carajito",    
        "hijueputa",   
        "zangolote",   
        "bicho e' gato",
        "mamar",        
        "güeyada",      
        "coñazo",       
        "trampa",       
        "huevonera",    
        "mierdero",     
        "verguero",     
        "tarado",       
        "bicho"         
    ];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->obsceneWords as $word) {
            if (stripos($value, $word) !== false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute contiene lenguaje inapropiado.';
    }
}
