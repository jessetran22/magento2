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
 * @Title("MC-13713: Create configurable product with images")
 * @Description("Admin should be able to create configurable product with images<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateConfigurableProductWithImagesTest.xml<br>")
 * @TestCaseId("MC-13713")
 * @group mtf_migrated
 */
class AdminCreateConfigurableProductWithImagesTestCest
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
		$I->comment("Create first attribute with 2 options");
		$I->createEntity("createFirstConfigProductAttribute", "hook", "productAttributeWithTwoOptionsNotVisible", [], []); // stepKey: createFirstConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOptionOne", "hook", "productAttributeOption1", ["createFirstConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionOne
		$I->createEntity("createConfigProductAttributeOptionTwo", "hook", "productAttributeOption2", ["createFirstConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionTwo
		$I->comment("Create second attribute with 2 options");
		$I->createEntity("createSecondConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createSecondConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOptionThree", "hook", "productAttributeOption3", ["createSecondConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionThree
		$I->createEntity("createConfigProductAttributeOptionFour", "hook", "productAttributeOption4", ["createSecondConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOptionFour
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createFirstConfigProductAttribute", "createSecondConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Delete created data");
		$I->deleteEntity("createFirstConfigProductAttribute", "hook"); // stepKey: deleteFirstConfigProductAttribute
		$I->deleteEntity("createSecondConfigProductAttribute", "hook"); // stepKey: deleteSecondConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Create configurable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateConfigurableProductWithImagesTest(AcceptanceTester $I)
	{
		$I->comment("Create configurable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleCreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->comment("Fill configurable product values");
		$I->comment("Entering Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillConfigurableProductValues
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillConfigurableProductValues
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillConfigurableProductValuesWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillConfigurableProductValues
		$I->comment("Exiting Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Add configurable product to category");
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProduct
		$I->comment("Exiting Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForConfigurationModalOpen
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationModalOpenWaitForPageLoad
		$I->comment("Create product configurations");
		$I->comment("Show 100 attributes per page");
		$I->comment("Entering Action Group [selectNumberOfAttributesPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownSelectNumberOfAttributesPerPage
		$I->click("//div[@class='admin__data-grid-pager-wrap']//div[@class='selectmenu-items _active']//li//button[text()='100']"); // stepKey: selectCustomPerPageSelectNumberOfAttributesPerPage
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadSelectNumberOfAttributesPerPage
		$I->comment("Exiting Action Group [selectNumberOfAttributesPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->comment("Add attributes and select all options");
		$I->click("//td[count(../../..//th[./*[.='Attribute Code']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createFirstConfigProductAttribute', 'attribute_code', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: clickOnFirstAttributeCheckbox
		$I->click("//td[count(../../..//th[./*[.='Attribute Code']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSecondConfigProductAttribute', 'attribute_code', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: clickOnSecondAttributeCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createFirstConfigProductAttribute', 'default_frontend_label', 'test') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickOnSelectAllInFirstAttribute
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createSecondConfigProductAttribute', 'default_frontend_label', 'test') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickOnSelectAllInSecondAttribute
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->comment("Add images to first product attribute options");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createFirstConfigProductAttribute', 'default_frontend_label', 'test')); // stepKey: selectOptionAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->attachFile("//*[text()='" . $I->retrieveEntityField('createConfigProductAttributeOptionOne', 'option[store_labels][1][label]', 'test') . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-logo.png"); // stepKey: uploadFileAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionOne
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionOne
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createFirstConfigProductAttribute', 'default_frontend_label', 'test')); // stepKey: selectOptionAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->attachFile("//*[text()='" . $I->retrieveEntityField('createConfigProductAttributeOptionTwo', 'option[store_labels][1][label]', 'test') . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-again.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionTwo
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionTwo
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Add price to second product attribute options");
		$I->comment("Entering Action Group [addPriceToConfigurableProductOptionThree] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionThree
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionThreeWaitForPageLoad
		$I->selectOption("#select-each-price", $I->retrieveEntityField('createSecondConfigProductAttribute', 'default_frontend_label', 'test')); // stepKey: selectOptionAddPriceToConfigurableProductOptionThree
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceToConfigurableProductOptionThreeWaitForPageLoad
		$I->fillField("//*[text()='" . $I->retrieveEntityField('createConfigProductAttributeOptionThree', 'option[store_labels][1][label]', 'test') . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceToConfigurableProductOptionThree
		$I->comment("Exiting Action Group [addPriceToConfigurableProductOptionThree] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addPriceToConfigurableProductOptionFour] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionFour
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionFourWaitForPageLoad
		$I->selectOption("#select-each-price", $I->retrieveEntityField('createSecondConfigProductAttribute', 'default_frontend_label', 'test')); // stepKey: selectOptionAddPriceToConfigurableProductOptionFour
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceToConfigurableProductOptionFourWaitForPageLoad
		$I->fillField("//*[text()='" . $I->retrieveEntityField('createConfigProductAttributeOptionFour', 'option[store_labels][1][label]', 'test') . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceToConfigurableProductOptionFour
		$I->comment("Exiting Action Group [addPriceToConfigurableProductOptionFour] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Add quantity to product attribute options");
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4WaitForPageLoad
		$I->comment("Save product");
		$I->comment("Entering Action Group [saveProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisibleSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAgainSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAgainSaveProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisibleSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleSaveProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopupSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupSaveProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Assert configurable product in category");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Entering Action Group [assertConfigurableProductInCategory] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]"); // stepKey: assertProductNameAssertConfigurableProductInCategory
		$I->see("$10.00", "//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//span[@class='price']"); // stepKey: AssertProductPriceAssertConfigurableProductInCategory
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAssertConfigurableProductInCategory
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), 'API Configurable Product" . msq("ApiConfigurableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartAssertConfigurableProductInCategory
		$I->comment("Exiting Action Group [assertConfigurableProductInCategory] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->comment("Assert product image in storefront product page");
		$I->amOnPage("api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: amOnProductPage
		$I->comment("Entering Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertProductImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->comment("Assert product options images in storefront product page");
		$I->comment("Entering Action Group [assertFirstOptionImageInStorefrontProductPage] AssertOptionImageInStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertFirstOptionImageInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertFirstOptionImageInStorefrontProductPage
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('createConfigProductAttributeOptionOne', 'option[store_labels][1][label]', 'test')); // stepKey: selectOption1AssertFirstOptionImageInStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeFirstImageAssertFirstOptionImageInStorefrontProductPage
		$I->comment("Exiting Action Group [assertFirstOptionImageInStorefrontProductPage] AssertOptionImageInStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [assertSecondOptionImageInStorefrontProductPage] AssertOptionImageInStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertSecondOptionImageInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSecondOptionImageInStorefrontProductPage
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('createConfigProductAttributeOptionTwo', 'option[store_labels][1][label]', 'test')); // stepKey: selectOption1AssertSecondOptionImageInStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-again')]"); // stepKey: seeFirstImageAssertSecondOptionImageInStorefrontProductPage
		$I->comment("Exiting Action Group [assertSecondOptionImageInStorefrontProductPage] AssertOptionImageInStorefrontProductPageActionGroup");
	}
}
