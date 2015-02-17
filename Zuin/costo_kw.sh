#!/bin/bash

# echo "Pubblica fascia del KWH su emoncms per calcolare il fascia"
costo=0
fascia=0
giorno=$(date +"%u")
ora=$(date +"%H")

if [ "$giorno" -lt "6" ];
 then  
  if [ "$ora" -ge "8" ];
   then  
    if [ "$ora" -lt "19" ];
     then
       fascia=1;
    fi
  fi
fi

if [ "$fascia" -eq "0" ];
 then
    if [ "$giorno" -lt "7" ];
     then  
      if [ "$ora" -ge "7" ];
       then  
        if [ "$ora" -lt "23" ];
         then
           fascia=2;
        fi
      fi
    fi
fi

if [ "$fascia" -eq "0" ];
 then
   fascia=3;
fi

if [ "$fascia" -eq "1" ];
 then
   costo=23;
fi
if [ "$fascia" -eq "2" ];
 then
   costo=21;
fi
if [ "$fascia" -eq "3" ];
 then
   costo=21;
fi


echo "giorno: $giorno  ora: $ora  fascia: $fascia   costo: $costo"  >> /var/www/emoncms/Zuin/log/log_exec.log
wget -O /dev/null --spider  "http://localhost:18001/emoncms/input/post.json?node=31&csv=${costo},${fascia}&apikey=913f557706d069745bfe8dac70040261" >> /var/www/emoncms/Zuin/log/log_exec.log

exit 0
