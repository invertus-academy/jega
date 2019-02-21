#                                                   Jega
# "Discount generator" - modulis kuris priskiria random kategorijom ar atskirom prekem pasirinktą nuolaidą. Adminas gali pasirinkiti kategorijų kiekį ir prekių kiekį, gali pasirinkti šablonus pagal datą (Black Friday, Kalėdos). Vartotojas gali vertinti nuolaidas. 
#Planas:
#1.Forma Catalog-> Random Discount skiltis
#2.Labelis kategorijoms pasirinkt- rodoma dropdownu. Labelis procentams įvesti- tikslus skaičius. Datos nurodymas. Save mygtukas
#2.Sugalvoti kaip pasirinktam produktui uždėti nuolaidą
#3.Ištestuoti nuolaidų uždėjimą kategorijoms

#Codinimas
#1.Duomenų bazė- nauja lentelė. Du laukai- AI ID ir spec_price_id (random sugeneruota nuolaida)
#2.Formos generavimas
#2.1.Kategorijų paiimams
#2.2.Prekių paiimimas
#2.3.Data nuo-iki
#2.4.Paėmus prekes į specific_price įrašo nuolaidą su visais nustatymais
#3. Front end
#3.1. Navigacijoj įdėti lauką (lucky discounts) kur rodomos visos random generuotos nuolaidos
#3.2. Vaizduoti prekes
