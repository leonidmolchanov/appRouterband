var MikroNode = require('mikronode');
 
 var device = new MikroNode('10.0.0.16');

 device.connect('admin','').then(function(connection) {

    var chan=conn.openChannel("addresses"); // open a named channel
    var chan2=conn.openChannel("firewall_connections",true); // open a named channel, turn on "closeOnDone"

    chan.write('/ip/address/print');

    chan.on('done',function(data) {

          // data is all of the sentences in an array.
          data.forEach(function(item) {
             console.log('Interface/IP: '+item.data.interface+"/"+item.data.address);
          });

          chan.close(); // close the channel.
          conn.close(); // when closing connection, the socket is closed and program ends.

       });
    });var MikroNode = require('mikronode-ng');

var connection = MikroNode.getConnection('10.0.0.11', 'admin', 'fender1987', {
    timeout : 4,
    closeOnDone : true,
    closeOnTimeout : true,
});

connection.on('error', function(err) {
    console.error('Error: ', err);
});