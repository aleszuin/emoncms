
var profile = {

  'get':function(profile_id)
  {
    var result = {};
    $.ajax({ url: path+"profile/get.json", dataType: 'json', data: "profile_id="+profile_id, async: false, success: function(data) {result = data;} });
    return result;
  },

  'save':function(profile_id,data)
  {
    var result = {};
    $.ajax({ url: path+"profile/save.json", data: "profile_id="+profile_id+"&data="+JSON.stringify(data), async: true, success: function(data){result = data;} });
    return result;
  },
}
