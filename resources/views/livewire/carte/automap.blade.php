
    
<div class="container">
    
    <div class="network"></div>
    
</div>

<script>
    
    let node = [];

    let edge = [];

    let child = [];

    let label;

    let fontColor;

    
    // Create Nodes :

    {!!$hosts!!}.forEach(function(host) {

        switch (host.current_state) {
                case 0:
                    label = 'Up';
                    fontColor = 'green';
                    break;

                case 1:
                    label = 'Down';
                    fontColor = 'red';
                    break;

                case 2:
                    label = 'Unreachable';
                    fontColor = 'violet';
                    break;
                default:
                    break;
        };

        label += '\n' + host.display_name + '\n' + host.address;

        node.push({

            id: host.host_object_id,
            label: label,
            font:{
                color:fontColor,
            },

        });


    });

    // Center of Network :

    node.push({

            id: 0,
            label: 'AM',
            font:{
                color:'blue',
            },
            shape:'circule',
            

    });
    

    let nodes = new vis.DataSet(node);

    // End Create Nodes
    

    // Create Edges (Relationship between nodes) :

    {!!$parent_hosts!!}.forEach(function(host) {

        edge.push({

            from : host.parent_host_object_id,
            to : host.host_object_id

        });

        child.push(host.host_object_id);

    });

    {!!$hosts!!}.forEach(function(host) {

        if (!child.includes(host.host_object_id)) {

        edge.push({

            from : 0,
            to : host.host_object_id

        });

        } 

    });

    let edges = new vis.DataSet(edge);

    

    const container = document.querySelector('.network');

    let data = {
        nodes: nodes,
        edges: edges
    };

    let options = {


            nodes: {
                fixed: true,
                font: {
                    size: 14,
                    face: 'arial'
                },
                borderWidth: 0,
                color: {
                    background: 'white',
                    border: "1",
                },


            },

            edges: {
                color: {
                    inherit: false
                },

                // dashes:true,

                // smooth: {
                //     enabled: true,
                //     type: 'dynamic'
                // },

                arrows: {
                    to: {
                        enabled: true,
                        scaleFactor: .25,
                        type: 'circle'
                    }
                },


            },


            interaction:{
                zoomView:true,

            },

            layout: {
                randomSeed: 0,
                hierarchical: {
                    enabled: true,
                    nodeSpacing: 100,
                    treeSpacing: 500,
                    // direction: 'LR'
                    parentCentralization: true,
                    // levelSeparation: 500

                }
            }
        };



        let Automap = new vis.Network(container, data, options);

</script>

