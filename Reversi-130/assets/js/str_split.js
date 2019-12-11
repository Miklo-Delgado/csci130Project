function str_split(string, split_length) {
  if (split_length === null) {//if the set is null then we assign the value of 1
    split_length = 1;
  }
  if (string === null || split_length < 1) {//we cant have the split equal null or equal to zero
    return false;
  }
  string += "";
  var chunks = [],
    pos = 0,
    len = string.length;
  while (pos < len) {//after we set the values for chunks we will push the values of the splice into the 
    //chunks array.
    chunks.push(string.slice(pos, (pos += split_length)));
  }

  return chunks;
}
