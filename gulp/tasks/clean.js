const fs = require("fs");

// clean task
function clean(done) {
  fs.rmSync("build", { recursive: true, force: true });
  done();
}

module.exports = {
  clean
}
