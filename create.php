<?php
/**
 * This string, if set, will be used to include a custom Javascript file to the
 * page.
 * @var string  The Javascript filename without the ".js" extension.
 */
$script = "create";
/**
 * The name of the current page, if any, for checking which is the active nav
 * menu link.
 * @var string  The slug of the current page.
 */
$page = "create";
require_once "header.php";

if ( $auth->isLoggedIn() ) {
  if ( !isset($_GET["do"]) ) { $_GET["do"] = "adventure"; }
?>

<main class="section">
  <div class="container">
    <div class="box">
      <?php
      switch ( $_GET["do"] ) {
        case "adventure":
      ?>
      <h2 class="title is-3">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-creation"></i>
          </span>
          <span>New Adventure</span>
        </span>
      </h2>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-hexagon"></i>
              </span>
              <span>Name</span>
            </span>
          </button>
        </div>
        <div class="control is-expanded">
          <input type="text" class="input" id="name" placeholder="Name of the adventure" autofocus>
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-image"></i>
              </span>
              <span>Cover</span>
            </span>
          </button>
        </div>
        <div class="control is-expanded">
          <input type="text" class="input" id="cover" placeholder="URI to cover image">
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-earth"></i>
                  </span>
                  <span>Setting</span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <input type="text" class="input" id="setting" placeholder="Enter setting">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-ray-start"></i>
                  </span>
                  <span>Lvl<sub>start</sub></span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <input type="number" class="input" id="level-start" placeholder="Initial party level" min="1" max="20" step="1">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-eye"></i>
                  </span>
                  <span>Visibility</sub></span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <div class="select is-fullwidth">
                <select id="is-public">
                  <option value="true" selected>Public</option>
                  <option value="false">Private</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-account-group"></i>
                  </span>
                  <span># PCs</span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <input type="number" class="input" id="pcs" placeholder="Number of PCs" min="1" step="1">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-ray-end"></i>
                  </span>
                  <span>Lvl<sub>end</sub></span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <input type="number" class="input" id="level-end" placeholder="Expected final party level" min="1" max="20" step="1">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">
                <span class="icon-text">
                  <span class="icon">
                    <i class="mdi mdi-ab-testing"></i>
                  </span>
                  <span>Dev. Status</sub></span>
                </span>
              </button>
            </div>

            <div class="control is-expanded">
              <div class="select is-fullwidth">
                <select id="is-public">
                  <option value="development">Development</option>
                  <option value="alpha">Alpha Test</option>
                  <option value="beta">Beta Test</option>
                  <option value="stable">Stable</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="field has-addons">
        <div class="control is-expanded">
          <input type="text" class="input" id="tw" data-type="tags" placeholder="Trigger warnings (comma-separated)">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <textarea class="textarea has-fixed-size" id="description" placeholder="Enter the description of your campaign here"></textarea>
        </div>
      </div>

      <div class="field">
        <div class="control is-expanded">
          <button class="button is-success is-fullwidth" id="create-adventure">Create</button>
        </div>
      </div>

      <?php
          break;
        default:
          // code...
          break;
      }
      ?>
    </div>
  </div>
</main>

<?php
}
require_once "footer.php";
?>
