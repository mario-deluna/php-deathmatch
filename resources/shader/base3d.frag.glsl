#version 330 core

out vec4 fragment_color;

in vec3 FragPos;  
in vec3 FragNormals;
in vec2 tCoords;
in vec3 LightPos;

uniform sampler2D texture1;
uniform float time;
  
void main()
{
    vec4 textcol = texture(texture1, tCoords);
    vec3 lightColor = vec3(1.0, 1.0, 0.9);
    vec3 objectColor = vec3(0.2, 0.2, 0.2);
    //vec3 objectColor = vec3(0.8, 0.8, 0.8);// * vec3(textcol.x, textcol.y, textcol.z);
    
    // ambient
    float ambientStrength = 0.6;
    vec3 ambient = ambientStrength * lightColor;    
    
     // diffuse 
    vec3 norm = normalize(FragNormals);
    vec3 lightDir = normalize(LightPos - FragPos);
    float diff = max(dot(norm, lightDir), 0.0);
    vec3 diffuse = diff * lightColor;
    
    // specular
    float specularStrength = 0.9;
    vec3 viewDir = normalize(-FragPos); // the viewer is always at (0,0,0) in view-space, so viewDir is (0,0,0) - Position => -Position
    vec3 reflectDir = reflect(-lightDir, norm);  
    float spec = pow(max(dot(viewDir, reflectDir), 0.0), 32);
    vec3 specular = specularStrength * spec * lightColor; 
    
    vec3 result = (ambient + diffuse + specular) * objectColor;
    fragment_color = vec4(result, 1.0);
    
    // // ambient
    // float ambientStrength = 0.5;
    // vec3 ambient = ambientStrength * lightColor;
    
    // // diffuse 
    // vec3 norm = normalize(FragNormals);
    // vec3 lightDir = normalize(lightPos - FragPos);
    // float diff = max(dot(norm, lightDir), 0.0);
    // vec3 diffuse = diff * lightColor;
            
    // vec3 result = (ambient + diffuse) * objectColor;
    // fragment_color = vec4(result, 1.0);
} 