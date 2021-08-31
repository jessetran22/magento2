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
 * @Title("MC-13339: Adding new options with images and prices to Configurable Product")
 * @Description("Test case verifies possibility to add new options for configurable attribute for existing configurable product.<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminAddingNewOptionsWithImagesAndPricesToConfigurableProductTest.xml<br>")
 * @TestCaseId("MC-13339")
 * @group configurableProduct
 */
class AdminAddingNewOptionsWithImagesAndPricesToConfigurableProductTestCest
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
		$I->comment("Entering Action Group [createConfigurableProduct] AdminCreateApiConfigurableProductActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProductFields['name'] = "API Configurable Product" . msq("ApiConfigurableProductWithOutCategory");
		$I->createEntity("createConfigProductCreateConfigurableProduct", "hook", "ApiConfigurableProductWithOutCategory", [], $createConfigProductCreateConfigurableProductFields); // stepKey: createConfigProductCreateConfigurableProduct
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProduct", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProduct", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProduct", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProduct
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProduct", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProduct
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProduct", "hook", "ApiSimpleOne", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct1CreateConfigurableProduct
		$I->createEntity("createConfigChildProduct2CreateConfigurableProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct2CreateConfigurableProduct
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProduct", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProduct", "createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigProductOptionCreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct1CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct2CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] AdminCreateApiConfigurableProductActionGroup");
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
		$I->deleteEntity("createConfigProductCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct2
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductActionGroup");
		$I->click("#menu-magento-catalog-catalog"); // stepKey: openCatalogDeleteProduct1
		$I->waitForPageLoad(5); // stepKey: waitForCatalogSubmenuDeleteProduct1
		$I->click("//li[@id='menu-magento-catalog-catalog']//li[@data-ui-id='menu-magento-catalog-catalog-products']"); // stepKey: clickOnProductsDeleteProduct1
		$I->waitForPageLoad(10); // stepKey: waitForProductsPageDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct1WaitForPageLoad
		$I->click("//*[contains(text(),'" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'hook') . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']"); // stepKey: TickCheckboxDeleteProduct1
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageDeleteProduct1
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: OpenActionsDeleteProduct1
		$I->waitForAjaxLoad(5); // stepKey: waitForDeleteDeleteProduct1
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: ChooseDeleteDeleteProduct1
		$I->waitForPageLoad(10); // stepKey: waitForDeleteItemPopupDeleteProduct1
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOnOkDeleteProduct1
		$I->waitForElementVisible("//*[@class='message message-success success']", 10); // stepKey: waitForSuccessfullyDeletedMessageDeleteProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearDeleteProduct1
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Update product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddingNewOptionsWithImagesAndPricesToConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Open edit product page");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Open edit configuration wizard");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickEditConfigurations
		$I->waitForPageLoad(30); // stepKey: clickEditConfigurationsWaitForPageLoad
		$I->see("Select Attributes", "div.content:not([style='display: none;']) .steps-wizard-title"); // stepKey: seeStepTitle
		$I->comment("Click Next button");
		$I->comment("Entering Action Group [navigateToAttributeValuesStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButtonNavigateToAttributeValuesStep
		$I->waitForPageLoad(30); // stepKey: waitForNextStepLoadedNavigateToAttributeValuesStep
		$I->see("Attribute Values", "div.content:not([style='display: none;']) .steps-wizard-title"); // stepKey: seeStepTitleNavigateToAttributeValuesStep
		$I->comment("Exiting Action Group [navigateToAttributeValuesStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->seeElement("//div[@class='attribute-entity']//div[normalize-space(.)='" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test') . "']"); // stepKey: seeAttribute
		$I->comment("Create one color option via \"Create New Value\" link");
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppears
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValueWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Green"); // stepKey: fillFieldForNewAttribute
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttributeWaitForPageLoad
		$I->comment("Click Next button");
		$I->comment("Entering Action Group [navigateToBulkStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButtonNavigateToBulkStep
		$I->waitForPageLoad(30); // stepKey: waitForNextStepLoadedNavigateToBulkStep
		$I->see("Bulk Images, Price and Quantity", "div.content:not([style='display: none;']) .steps-wizard-title"); // stepKey: seeStepTitleNavigateToBulkStep
		$I->comment("Exiting Action Group [navigateToBulkStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->comment("Select Apply unique images by attribute to each SKU and color attribute in dropdown in Images");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test')); // stepKey: selectAttributeOption
		$I->waitForPageLoad(30); // stepKey: selectAttributeOptionWaitForPageLoad
		$I->comment("Add images to configurable product attribute options");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test')); // stepKey: selectOptionAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->attachFile("//*[text()='" . $I->retrieveEntityField('getConfigAttributeOption1CreateConfigurableProduct', 'label', 'test') . "']/../../div[@data-role='gallery']//input[@type='file']", "magento.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionOne
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionOne
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test')); // stepKey: selectOptionAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->attachFile("//*[text()='" . $I->retrieveEntityField('getConfigAttributeOption2CreateConfigurableProduct', 'label', 'test') . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-again.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionTwo
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionTwo
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionThree] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionThree
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionThreeWaitForPageLoad
		$I->selectOption("#apply-images-attributes", $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test')); // stepKey: selectOptionAddImageToConfigurableProductOptionThree
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionThreeWaitForPageLoad
		$I->attachFile("//*[text()='Green']/../../div[@data-role='gallery']//input[@type='file']", "magento3.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionThree
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionThreeWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionThree
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento3')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionThree
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionThree] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Add prices to configurable product attribute options");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesByAttributeToEachSkuWaitForPageLoad
		$I->selectOption("#select-each-price", $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'default_frontend_label', 'test')); // stepKey: selectAttributes
		$I->waitForPageLoad(30); // stepKey: selectAttributesWaitForPageLoad
		$I->fillField("//*[text()='" . $I->retrieveEntityField('getConfigAttributeOption1CreateConfigurableProduct', 'label', 'test') . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: fillAttributePrice
		$I->fillField("//*[text()='" . $I->retrieveEntityField('getConfigAttributeOption2CreateConfigurableProduct', 'label', 'test') . "']/../..//input[contains(@id, 'apply-single-price-input')]", "20"); // stepKey: fillAttributePrice1
		$I->fillField("//*[text()='Green']/../..//input[contains(@id, 'apply-single-price-input')]", "30"); // stepKey: fillAttributePrice2
		$I->comment("Add quantity to product attribute options");
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantity
		$I->comment("Click Next button");
		$I->comment("Entering Action Group [navigateToSummaryStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButtonNavigateToSummaryStep
		$I->waitForPageLoad(30); // stepKey: waitForNextStepLoadedNavigateToSummaryStep
		$I->see("Summary", "div.content:not([style='display: none;']) .steps-wizard-title"); // stepKey: seeStepTitleNavigateToSummaryStep
		$I->comment("Exiting Action Group [navigateToSummaryStep] AdminConfigurableWizardMoveToNextStepActionGroup");
		$I->comment("Click Generate Configure button");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Generate Products')]"); // stepKey: clickGenerateConfigure
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Go to frontend and check image and price");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->comment("Entering Action Group [assertFirstOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption1CreateConfigurableProduct', 'label', 'test')); // stepKey: selectOptionAssertFirstOptionImageAndPriceInStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento')]"); // stepKey: seeImageAssertFirstOptionImageAndPriceInStorefrontProductPage
		$I->see("10", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertFirstOptionImageAndPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [assertFirstOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
		$I->comment("Entering Action Group [assertSecondOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption2CreateConfigurableProduct', 'label', 'test')); // stepKey: selectOptionAssertSecondOptionImageAndPriceInStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-again')]"); // stepKey: seeImageAssertSecondOptionImageAndPriceInStorefrontProductPage
		$I->see("20", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertSecondOptionImageAndPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [assertSecondOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
		$I->comment("Entering Action Group [assertThirdOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Green"); // stepKey: selectOptionAssertThirdOptionImageAndPriceInStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento3')]"); // stepKey: seeImageAssertThirdOptionImageAndPriceInStorefrontProductPage
		$I->see("30", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertThirdOptionImageAndPriceInStorefrontProductPage
		$I->comment("Exiting Action Group [assertThirdOptionImageAndPriceInStorefrontProductPage] AssertOptionImageAndPriceInStorefrontProductActionGroup");
	}
}
