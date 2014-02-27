
<div id="linkdialog" class="reveal-modal tiny" data-reveal>
    
        <div class='row'>
            <h4 >Add Link</h4>
        </div>
        <div class='row'>
            <div action='#' id='markdown_add_link'>
            {{Form::text('link-href', '',array('placeholder'=>'enter link address (http://www.goodlink.com)'))}}
            {{Form::text('link-description', '',array('placeholder'=>'description'))}}
            </div>
        </div>
        <div class="row">
            <button class='button small' id='addLinkBtn'>Add Link</button>
            <button style='background-color:#cc3333' class="button small modalclose">Close</button>
            
            
        </div>
    
</div>


<div id="imagedialog" class="reveal-modal medium" data-reveal>
        <div class='row'>
            <h4 >Add Image</h4>
        </div>
        <div id='markdown_add_image'>
          <div class='row'>
            {{Form::text('image-description', '',array('placeholder'=>'image title/ alt text'))}}
          </div>
          <div class='row'>
            {{Form::text('image-href', '',array('placeholder'=>'enter link address (http://www.goodlink.com/image.jpg)'))}}
          </div>
        </div>
        <div class="row">
            <button class='button small' id='addImageBtn'>Add Link</button>
            <button style='background-color:#cc3333' class="button small modalclose">Close</button>
        </div>            
</div>

<div id="functiondialog" class="reveal-modal medium" data-reveal>
        <div class='row'>
            <h4 >Add Math</h4>
        </div>
        <div class='row'>

          <p>We use MathJax to generate our math content. You can read more about it {{HTML::link('#','here')}}</p>
          <p>Some of the features may not work right now. We're working to improve that. Here are some equations for a good base on how it works.</p>
          </div>
          <div class='row'>
          <table class='table large-12'>
              <tr>
                  <td><span class='equation'>$$x_2=4$$</span></td>
                  <td><button class='addeqnbtn small button success' data-eqn='x_2=4'>add</button></td>
              </tr>
              <tr>
                  <td><span class='equation'>$$  x^2 \times i \over \sqrt{a} $$</span></td>
                  <td><button class='addeqnbtn small button success' data-eqn='x^2 \times i \over \sqrt{a}'> add</button></td>
              </tr>
              <tr>
                  <td><span class='equation'> $$ \mathbf{V}_1 \times \mathbf{V}_2 = \begin{vmatrix} \mathbf{i} & \mathbf{j} & \mathbf{k} \\ \frac{\partial X}{\partial u} & \frac{\partial Y}{\partial u} & 0 \\ \frac{\partial X}{\partial v} & \frac{\partial Y}{\partial v} & 0 \\\end{vmatrix} $$</span></td>
                  <td><button class='addeqnbtn small button success' data-eqn='\mathbf{V}_1 \times \mathbf{V}_2 = \begin{vmatrix} \mathbf{i} & \mathbf{j} & \mathbf{k} \\ \frac{\partial X}{\partial u} & \frac{\partial Y}{\partial u} & 0 \\ \frac{\partial X}{\partial v} & \frac{\partial Y}{\partial v} & 0 \\\end{vmatrix} '>add</button></td>
              </tr>
              <tr>
                  <td>$$ P(E) = {n \choose k} p^k (1-p)^{ n-k} $$</td>
                  <td><button class='addeqnbtn small button success' data-eqn='{n \choose k} p^k (1-p)^{ n-k}'> add </button></td>
              </tr>
              <tr>
                  <td> $$\frac{1}{(\sqrt{\phi \sqrt{5}}-\phi) e^{\frac25 \pi}} = 1+\frac{e^{-2\pi}} {1+\frac{e^{-4\pi}} {1+\frac{e^{-6\pi}} {1+\frac{e^{-8\pi}} {1+\ldots} } } }$$</td>
                  <td><button class='addeqnbtn small button success' data-eqn='\frac{1}{(\sqrt{\phi \sqrt{5}}-\phi) e^{\frac25 \pi}} = 1+\frac{e^{-2\pi}} {1+\frac{e^{-4\pi}} {1+\frac{e^{-6\pi}} {1+\frac{e^{-8\pi}} {1+\ldots} } } }'> add </button></td>
              </tr>
              <tr>
                  <td>  $$ 1 +  \frac{q^2}{(1-q)}+\frac{q^6}{(1-q)(1-q^2)}+\cdots =\prod_{j=0}^{\infty}\frac{1}{(1-q^{5j+2})(1-q^{5j+3})}, \quad\quad \text{for $|q|<1$}  $$ </td>
                  <td><button class='addeqnbtn small button success' data-eqn=' 1 +  \frac{q^2}{(1-q)}+\frac{q^6}{(1-q)(1-q^2)}+\cdots =\prod_{j=0}^{\infty}\frac{1}{(1-q^{5j+2})(1-q^{5j+3})}, \quad\quad \text{for $|q|<1$}'> add </button></td>
              </tr>
              <tr>
                <td>  $$
                            \begin{align}  \nabla \times \vec{\mathbf{B}} -\, \frac1c\, \frac{\partial\vec{\mathbf{E}}}{\partial t} & = \frac{4\pi}{c}\vec{\mathbf{j}} \\  \nabla \cdot \vec{\mathbf{E}} & = 4 \pi \rho \\  \nabla \times \vec{\mathbf{E}}\, +\, \frac1c\, \frac{\partial\vec{\mathbf{B}}}{\partial t} & = \vec{\mathbf{0}} \\  \nabla \cdot \vec{\mathbf{B}} & = 0
                    \end{align}$$
                  </td>
                  <td><button class='addeqnbtn small button success' data-eqn='
                            \begin{align}  \nabla \times \vec{\mathbf{B}} -\, \frac1c\, \frac{\partial\vec{\mathbf{E}}}{\partial t} & = \frac{4\pi}{c}\vec{\mathbf{j}} \\  \nabla \cdot \vec{\mathbf{E}} & = 4 \pi \rho \\  \nabla \times \vec{\mathbf{E}}\, +\, \frac1c\, \frac{\partial\vec{\mathbf{B}}}{\partial t} & = \vec{\mathbf{0}} \\  \nabla \cdot \vec{\mathbf{B}} & = 0
                    \end{align}'> add </button></td>
              </tr>

          </table>
          </div>
          <div class='row'>
            <button style='background-color:#cc3333' class="button small modalclose">Close</button>
          </div>
</div>