$(function() {
  try {
    var modelXml = $.parseXML($("#model-xml").text().trim()),
        configurationXml = $.parseXML($("#configuration-xml").text().trim()),
        model = new Model(new XmlModel(modelXml)),
        configuration = Configuration.fromXml(model, configurationXml),
        options = {
          target: $(".configurator"),

          renderer: {
            afterRender: function() {
              var self = this;
              $(".export").show().prop("disabled", !self.configuration.isComplete()).
                           unbind("click").click(function() {
                             if (self.configuration.isComplete()) {
                               $("#configuration").val(self.configuration.serialize());
                               $("form").submit();
                             }
                           });
            },

            renderLabel: function(label, feature) {
              var klass = this.configuration.isEnabled(feature) ? "enabled" : this.configuration.isDisabled(feature) ? "disabled" : "";
              var selectable = this.configuration.isManual(feature) || !this.configuration.isAutomatic(feature);
              var regex = /\[label=(.*?)\]/;
              var text = regex.exec(feature.description);
              text = text && text.length === 2 ? text[1] : feature.name;
              var description = feature.description && feature.description.replace(regex, "").trim();
              label = label
                .addClass(klass)
                .addClass(selectable ? "selectable" : "")
                .text(text)
                .attr("id", feature.name);
              if (description)
                label = label.append($("<div></div>")
                  .addClass("mdl-tooltip mdl-tooltip--large mdl-tooltip--right")
                  .attr("for", feature.name)
                  .text(description));
              return label;
            },

            renderFeature: function(feature) {
              if (feature.description && feature.description.indexOf("[hidden]") !== -1)
                return "";
              return this.getOptions().renderFeature.call(this, feature);
            },

            initializeFeature: function(node, feature, fn) {
              this.getOptions().initializeFeature.call(this, node, feature, fn);
              var tooltip = node.find(".mdl-tooltip").get(0);
              if (tooltip)
                componentHandler.upgradeElement(tooltip);
            }
          }
        };

    window.app = new Configurator(model, options, configuration);

    $(".reset").click(function() {
      window.app.render();
      $('.mdl-js-radio').map(function() {
        this.MaterialRadio.uncheck();
      });
    });

    $("input[name='data-source']").change(function() {
      $.ajax("?p=api&configuration=" + $(this).val()).then(function(res) {
        var configurationXml = $.parseXML(res),
            configuration = Configuration.fromXml(model, configurationXml);
        window.app.render(configuration);
      });
    });
  } catch (e) {
    alert(e);
  }
});
