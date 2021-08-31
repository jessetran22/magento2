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
 * @Title("MC-5685: Admin is able to create an product with a long sku below that is below the character limit")
 * @Description("Try to create a product with sku slightly less than char limit. Get client side SKU length error for child products. Correct SKUs and save product succeeds.<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductLongSkuTest.xml<br>")
 * @TestCaseId("MC-5685")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductLongSkuTestCest
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
		$I->comment("Create product attribute with options");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create Category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clean up products");
		$I->comment("Entering Action Group [cleanUpProducts] DeleteProductByNameActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageCleanUpProducts
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersCleanUpProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersCleanUpProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersCleanUpProducts
		$I->fillField("input.admin__control-text[name='name']", "Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku")); // stepKey: fillProductSkuFilterCleanUpProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersCleanUpProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersCleanUpProductsWaitForPageLoad
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridCleanUpProducts
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownCleanUpProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridCleanUpProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownCleanUpProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownCleanUpProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionCleanUpProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionCleanUpProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalCleanUpProducts
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalCleanUpProductsWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteCleanUpProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteCleanUpProductsWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageCleanUpProducts
		$I->comment("Exiting Action Group [cleanUpProducts] DeleteProductByNameActionGroup");
		$I->comment("Clean up attribute");
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Clean up category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductLongSkuTest(AcceptanceTester $I)
	{
		$I->comment("Create a configurable product with long name and sku");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: goToProductCreatePage
		$I->waitForPageLoad(30); // stepKey: waitForProductCreatePage
		$I->fillField(".admin__field[data-index=name] input", "Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPrice
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->comment("Setup configurations");
		$I->comment("Entering Action Group [setupConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsSetupConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersSetupConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldSetupConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSetupConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxSetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1SetupConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllSetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2SetupConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuSetupConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantitySetupConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3SetupConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4SetupConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4SetupConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [setupConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("See SKU length errors in Current Variations grid");
		$I->comment("Entering Action Group [saveProductFail] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProductFail
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductFailWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProductFail
		$I->comment("Exiting Action Group [saveProductFail] AdminProductFormSaveActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeRemainOnCreateProductPage
		$I->see("Please enter less or equal than 64 symbols.", "[data-index='configurable-matrix'] table > tbody > tr:nth-of-type(1) .admin__field-error"); // stepKey: seeSkuTooLongError1
		$I->see("Please enter less or equal than 64 symbols.", "[data-index='configurable-matrix'] table > tbody > tr:nth-of-type(2) .admin__field-error"); // stepKey: seeSkuTooLongError2
		$I->comment("Fix SKU lengths");
		$I->fillField("[data-index='configurable-matrix'] table > tbody > tr:nth-of-type(1) input[name*='sku']", "LongSku-" . $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: fixConfigurationSku1
		$I->fillField("[data-index='configurable-matrix'] table > tbody > tr:nth-of-type(2) input[name*='sku']", "LongSku-" . $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: fixConfigurationSku2
		$I->comment("Save product successfully");
		$I->comment("Entering Action Group [saveProductSuccess] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProductSuccess
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductSuccessWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProductSuccess
		$I->comment("Exiting Action Group [saveProductSuccess] AdminProductFormSaveActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessage
		$I->comment("Assert configurations on the product edit pag");
		$I->seeNumberOfElements(".data-row", "2"); // stepKey: seeNumberOfRows
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku") . "-" . $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeChildProductName1
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku") . "-" . $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeChildProductName2
		$I->see("LongSku-" . $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), ".admin__control-fields[data-index='sku_container']"); // stepKey: seeChildProductSku1
		$I->see("LongSku-" . $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), ".admin__control-fields[data-index='sku_container']"); // stepKey: seeChildProductSku2
		$I->see("123.00", ".admin__control-fields[data-index='price_container']"); // stepKey: seeConfigurationsPrice
		$I->comment("Run re-index task");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Assert storefront category list page");
		$I->amOnPage("/"); // stepKey: amOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontLoad
		$I->click($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: clickOnCategoryName
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku")); // stepKey: assertProductPresent
		$I->see("123.00"); // stepKey: assertProductPricePresent
		$I->comment("Assert storefront product details page");
		$I->click("//main//li//a[contains(text(), 'Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku") . "')]"); // stepKey: clickOnProductName
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->seeInTitle("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku")); // stepKey: assertProductNameTitle
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku"), ".base"); // stepKey: assertProductName
		$I->see("Product With Long Name And Sku - But not too long" . msq("ProductWithLongNameSku"), ".product.attribute.sku>.value"); // stepKey: assertProductSku
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test'), "#product-options-wrapper div[tabindex='0'] label"); // stepKey: seeColorAttributeName1
		$I->see($I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), "#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeInDropDown1
		$I->see($I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), "#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeInDropDown2
	}
}
