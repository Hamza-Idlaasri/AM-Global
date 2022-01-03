    
<div>
    <ul class="accordion-menu">
        <li>
            <a href="/overview" id="overview">
                <div class="dropdownlink">
                    <b><i class="far fa-globe"></i> Overview</b>
                </div>
            </a>
        </li>
    
        <li onclick="droped(1)">
            <div class="dropdownlink">
                <b><i class="far fa-eye"></i> Monitoring</b>
            </div>
            <ul class="submenuItems">
                <li>
                    <a href="/monitoring/hosts"><i class="fas fa-desktop"></i> Hosts</a>
                </li>
                <li>
                    <a href="/monitoring/services" ><i class="fas fa-cog"></i> Services</a>
                </li>
                <li>
                    <a href="/monitoring/boxs"><i class="fas fa-microchip"></i> Boxs</a>
                </li>
                <li>
                    <a href="/monitoring/equipements"><img src="" alt=""> Equipements</a>
                </li>
                
            </ul>
        </li>
        <li onclick="droped(2)">
            <div class="dropdownlink"><i class="fas fa-exclamation-triangle"></i><b> Problémes</b>
                
                
            </div>
            <ul class="submenuItems">
                <li>
                    <a href="/problems/hosts"><i class="fas fa-desktop"></i> Hosts</a>
                </li>
                <li>
                    <a href="/problems/services" ><i class="fas fa-cog"></i> Services</a>
                </li>
                <li>
                    <a href="/problems/boxs"><i class="fas fa-microchip"></i> Boxs</a>
                </li>
                <li>
                    <a href="/problems/equipements"><img src="" alt=""> Equipements</a>
                </li>
            </ul>
        </li>
    
        
        
        <li onclick="droped(3)">
            <div class="dropdownlink"><i class="fas fa-chart-bar"></i><b> Statistiques</b>
                
            </div>
            <ul class="submenuItems">
                <li>
                    <a href="/statistiques/hosts"><i class="fas fa-desktop"></i> Hosts</a>
                </li>
                <li>
                    <a href="/statistiques/services"><i class="fas fa-cog"></i> Services</a>
                </li>
                <li>
                    <a href="/statistiques/boxs"><i class="fas fa-cog"></i> Boxs</a>
                </li>
                <li>
                    <a href="/statistiques/equipements"><img src="{{----}}" alt=""> Equipements</a>
                </li>
            </ul>
        </li>

        <li onclick="droped(4)">
            <div class="dropdownlink"><i class="far fa-map-marked-alt"></i><b> Cartes</b>
                
            </div>
            <ul class="submenuItems">
                <li>
                    <a href="/carte/automap"><i class="fas fa-chart-network"></i> AutoMap</a>
                </li>
                {{-- <li>
                    <a href="#"><i class="fas fa-chart-network"></i> AutoMap 2</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-network"></i> AutoMap 3</a>
                </li> --}}
                {{-- <li>
                    <a href="#"><i class="far fa-map"></i> Cartes</a>
                </li> --}}
            </ul>
        </li>
        <li onclick="droped(5)">
            <div class="dropdownlink">
                <i class="far fa-calendar-alt"></i><b> Historiques</b>
            </div>
            <ul class="submenuItems">
                <li>
                    <a href="/historiques/hosts"><i class="fas fa-desktop"></i> Hosts</a>
                </li>
                <li>
                    <a href="/historiques/services"><i class="fas fa-cog"></i> Services</a>
                </li>
                <li>
                    <a href="/historiques/boxs"><i class="fas fa-microchip"></i> Boxs</a>
                </li>
                <li>
                     <a href="/historiques/equipements"><img {{--src=""--}} alt=""> Equipements</a> 
                </li>
            </ul>
        </li>

        <li>
            <a href="/notifications" id="overview">
                <div class="dropdownlink">
                    <b><i class="fas fa-bell"></i> Notifications</b>
                </div>
            </a>
        </li>

        <li>
            <a href="/sites" id="overview">
                <div class="dropdownlink">
                    <b><i class="fas fa-map-marker-alt"></i> Sites</b>
                </div>
            </a>
        </li>

        <li>
            <div class="toggle-on">
                <button class="tg-btn-on"><i class="fas fa-chevron-left"></i></button>
            </div>
        </li>
    </ul>
</div>



