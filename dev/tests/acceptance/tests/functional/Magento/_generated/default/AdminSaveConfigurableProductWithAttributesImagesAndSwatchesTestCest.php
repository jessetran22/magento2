<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-13641: Saving configurable product with custom product attribute (images as swatches)")
 * @Description("Saving configurable product with custom product attribute (images as swatches)<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminSaveConfigurableProductWithAttributesImagesAndSwatchesTest.xml<br>")
 * @TestCaseId("MC-13641")
 * @group catalog
 */
class AdminSaveConfigurableProductWithAttributesImagesAndSwatchesTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create a new product attribute");
		$I->comment("Entering Action Group [openProductAttributePage] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageOpenProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadOpenProductAttributePage
		$I->comment("Exiting Action Group [openProductAttributePage] AdminOpenProductAttributePageActionGroup");
		$I->click("#add"); // stepKey: createNewAttribute
		$I->comment("Set Catalog Input Type for Store Owner: Visual Swatch");
		$I->comment("Entering Action Group [fillAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->fillField("#attribute_label", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: fillDefaultLabelFillAttributeProperties
		$I->selectOption("#frontend_input", "swatch_visual"); // stepKey: selectInputTypeFillAttributeProperties
		$I->comment("Exiting Action Group [fillAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->comment("Add a few Swatches and add images to Manage Swatch (Values of Your Attribute)
             1. Set swatch #1 using the color picker");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddFirstSwatch
		$I->waitForPageLoad(30); // stepKey: clickAddFirstSwatchWaitForPageLoad
		$I->comment("Entering Action Group [clickFirstSwatch] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickFirstSwatch = $I->executeJS("jQuery('#swatch_window_option_option_0').click()"); // stepKey: clickSwatch1ClickFirstSwatch
		$I->comment("Exiting Action Group [clickFirstSwatch] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_row_name.colorpicker_handler"); // stepKey: clickChooseColor
		$I->comment("Entering Action Group [fillFirstHex] SetColorPickerByHexActionGroup");
		$I->comment("This 6x backspace stuff is some magic that is necessary to interact with this field correctly");
		$I->pressKey("//div[@class='colorpicker'][1]/div[@class='colorpicker_hex']/input", \Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,\Facebook\WebDriver\WebDriverKeys::BACKSPACE,'e74c3c'); // stepKey: fillHex1FillFirstHex
		$I->click("//div[@class='colorpicker'][1]/div[@class='colorpicker_submit']"); // stepKey: submitColor1FillFirstHex
		$I->comment("Exiting Action Group [fillFirstHex] SetColorPickerByHexActionGroup");
		$I->fillField("optionvisual[value][option_0][0]", "red"); // stepKey: fillFirstAdminField
		$I->comment("Set swatch #2 using upload file");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSecondSwatch
		$I->waitForPageLoad(30); // stepKey: clickAddSecondSwatchWaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch2 = $I->executeJS("jQuery('#swatch_window_option_option_1').click()"); // stepKey: clickSwatch1ClickSwatch2
		$I->comment("Exiting Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile2
		$I->attachFile("input[name='datafile']", "adobe-small.jpg"); // stepKey: attachFile
		$I->fillField("optionvisual[value][option_1][0]", "adobe-small"); // stepKey: fillAdminLabel
		$I->comment("Set Scope: Global in Advanced Attribute Properties");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedProperties
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScope
		$I->comment("Click \"Save Attribute\" button");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEditWaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccessMessage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product attribute and clear grid filter");
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'visual_swatch" . msq("VisualSwatchProductAttribute") . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see("visual_swatch" . msq("VisualSwatchProductAttribute"), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'visual_swatch" . msq("VisualSwatchProductAttribute") . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeSuccess
		$I->comment("Exiting Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->comment("Entering Action Group [clearAttributesGridFilter] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearAttributesGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearAttributesGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearAttributesGridFilter
		$I->comment("Exiting Action Group [clearAttributesGridFilter] AdminGridFilterResetActionGroup");
		$I->comment("Clear products grid filter");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilter] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearProductsGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearProductsGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearProductsGridFilter
		$I->comment("Exiting Action Group [clearProductsGridFilter] AdminGridFilterResetActionGroup");
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Swatches"})
	 * @Stories({"Product attributes"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSaveConfigurableProductWithAttributesImagesAndSwatchesTest(AcceptanceTester $I)
	{
		$I->comment("Add created product attribute to the Default set");
		$I->comment("Entering Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetPageOpenAttributeSetPage
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenAttributeSetPage
		$I->comment("Exiting Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->comment("Entering Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->click("//td[contains(text(), 'Default')]"); // stepKey: chooseAttributeSetOpenDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenDefaultAttributeSet
		$I->comment("Exiting Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='visual_swatch" . msq("VisualSwatchProductAttribute") . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see("visual_swatch" . msq("VisualSwatchProductAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Create configurable product");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownGoToCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlGoToCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateConfigurableProduct
		$I->comment("Exiting Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->comment("Fill all the necessary information such as weight, name, SKU etc");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->comment("Click \"Create Configurations\" button, select created product attribute using the same Quantity for all products. Click \"Generate products\" button");
		$I->comment("Entering Action Group [addAttributeToProduct] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsAddAttributeToProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddAttributeToProduct
		$I->fillField(".admin__control-text[name='attribute_code']", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: fillFilterAttributeCodeFieldAddAttributeToProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAddAttributeToProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxAddAttributeToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1AddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1AddAttributeToProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllAddAttributeToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2AddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2AddAttributeToProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuAddAttributeToProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityAddAttributeToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3AddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3AddAttributeToProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4AddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4AddAttributeToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addAttributeToProduct] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Using this action to concatenate 2 strings to have unique identifier for grid");
		$attributeCodeRed = $I->executeJS("return 'visual_swatch" . msq("VisualSwatchProductAttribute") . ": red'"); // stepKey: attributeCodeRed
		$attributeCodeAdobeSmall = $I->executeJS("return 'visual_swatch" . msq("VisualSwatchProductAttribute") . ": adobe-small'"); // stepKey: attributeCodeAdobeSmall
		$I->comment("Add images for the products");
		$I->attachFile("//tbody/tr[td[*[contains(.,normalize-space('{$attributeCodeRed}'))]]]//input[@type='file' and @class='file-uploader-input']", "magento-logo.png"); // stepKey: uploadImageForFirstProduct
		$I->attachFile("//tbody/tr[td[*[contains(.,normalize-space('{$attributeCodeAdobeSmall}'))]]]//input[@type='file' and @class='file-uploader-input']", "adobe-base.jpg"); // stepKey: uploadImageForSecondProduct
		$I->comment("Click \"Save\" button");
		$I->comment("Entering Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveButton
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveButtonWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveButton
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveButton
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->comment("Delete all created product");
		$I->comment("Entering Action Group [deleteCreatedProducts] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteCreatedProducts
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCreatedProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteCreatedProducts
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteCreatedProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductsWaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProducts
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteCreatedProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteCreatedProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteCreatedProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteCreatedProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteCreatedProducts
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteCreatedProductsWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteCreatedProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteCreatedProductsWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedProducts
		$I->comment("Exiting Action Group [deleteCreatedProducts] DeleteProductBySkuActionGroup");
	}
}
