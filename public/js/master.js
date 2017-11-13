function trans(key,attributes){
    try {
        var translation = translations[key];
        if(attributes){
            for(attribute in attributes){
                translation = translation.replace(':'+attribute,attributes[attribute]);
            }
        }
    }
    catch(err) {
        var translation = key;
    }

    return translation;
}

function trans_choice(key,attributes){
    var translation = translations[key].split("|");
    if(attributes){
        for(attribute in attributes){
            if(parseInt(attributes[attribute],10)<=1)
            translation = translation[0].replace(':'+attribute,attributes[attribute]);
            else
            translation = translation[1].replace(':'+attribute,attributes[attribute]);
        }
    }
    return translation;
}