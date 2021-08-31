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
 * @Title("MC-23027: Customer should get the right options list")
 * @Description("Customer should get the right options list for each variation of configurable product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontConfigurableProductDetailsTest/StorefrontConfigurableProductVariationsTest.xml<br>")
 * @TestCaseId("MC-23027")
 * @group configurable_product
 */
class StorefrontConfigurableProductVariationsTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Add first attribute with options");
		$I->createEntity("createFirstAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createFirstAttribute
		$I->createEntity("createFirstAttributeFirstOption", "hook", "productAttributeOption1", ["createFirstAttribute"], []); // stepKey: createFirstAttributeFirstOption
		$I->createEntity("createFirstAttributeSecondOption", "hook", "productAttributeOption2", ["createFirstAttribute"], []); // stepKey: createFirstAttributeSecondOption
		$I->comment("Add second attribute with options");
		$I->createEntity("createSecondAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createSecondAttribute
		$I->createEntity("createSecondAttributeFirstOption", "hook", "productAttributeOption1", ["createSecondAttribute"], []); // stepKey: createSecondAttributeFirstOption
		$I->createEntity("createSecondAttributeSecondOption", "hook", "productAttributeOption2", ["createSecondAttribute"], []); // stepKey: createSecondAttributeSecondOption
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
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("configurable" . msq("BaseConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->deleteEntity("createFirstAttribute", "hook"); // stepKey: deleteFirstAttribute
		$I->deleteEntity("createSecondAttribute", "hook"); // stepKey: deleteSecondAttribute
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Configurable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductVariationsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [navigateToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleNavigateToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleNavigateToCreateProductPageWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownNavigateToCreateProductPage
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeNavigateToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadNavigateToCreateProductPage
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlNavigateToCreateProductPage
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleNavigateToCreateProductPage
		$I->comment("Exiting Action Group [navigateToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->comment("Entering Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryAddCategoryToProduct
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryAddCategoryToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->comment("Entering Action Group [fillUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSeoSectionFillUrlKey
		$I->fillField("input[name='product[url_key]']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillUrlKeyFillUrlKey
		$I->comment("Exiting Action Group [fillUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsWaitForPageLoad
		$I->comment("Entering Action Group [checkFirstAttribute] AdminSelectAttributeInConfigurableAttributesGrid");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearFiltersCheckFirstAttribute
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetCheckFirstAttribute
		$I->waitForElementVisible("button[data-action='grid-filter-expand']", 30); // stepKey: waitForFiltersAppearCheckFirstAttribute
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: expandFiltersCheckFirstAttribute
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createFirstAttribute', 'attribute_code', 'test')); // stepKey: fillFilterValueCheckFirstAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersCheckFirstAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersCheckFirstAttributeWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: checkAttributeInGridCheckFirstAttribute
		$I->comment("Exiting Action Group [checkFirstAttribute] AdminSelectAttributeInConfigurableAttributesGrid");
		$I->comment("Entering Action Group [checkSecondAttribute] AdminSelectAttributeInConfigurableAttributesGrid");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearFiltersCheckSecondAttribute
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetCheckSecondAttribute
		$I->waitForElementVisible("button[data-action='grid-filter-expand']", 30); // stepKey: waitForFiltersAppearCheckSecondAttribute
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: expandFiltersCheckSecondAttribute
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createSecondAttribute', 'attribute_code', 'test')); // stepKey: fillFilterValueCheckSecondAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersCheckSecondAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersCheckSecondAttributeWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: checkAttributeInGridCheckSecondAttribute
		$I->comment("Exiting Action Group [checkSecondAttribute] AdminSelectAttributeInConfigurableAttributesGrid");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStepLoad
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createFirstAttribute', 'default_frontend_label', 'test') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickFirstAttributeSelectAll
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createSecondAttribute', 'default_frontend_label', 'test') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickSecondAttributeSelectAll
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickSecondNextStep
		$I->waitForPageLoad(30); // stepKey: clickSecondNextStepWaitForPageLoad
		$I->waitForElement(".steps-wizard-navigation .action-next-step", 30); // stepKey: waitThirdNextButton
		$I->waitForPageLoad(30); // stepKey: waitThirdNextButtonWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickThirdStep
		$I->waitForPageLoad(30); // stepKey: clickThirdStepWaitForPageLoad
		$I->waitForElement(".steps-wizard-navigation .action-next-step", 30); // stepKey: waitGenerateConfigurationsButton
		$I->waitForPageLoad(30); // stepKey: waitGenerateConfigurationsButtonWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickToGenerateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickToGenerateConfigurationsWaitForPageLoad
		$I->waitForElementVisible(".admin__field[data-index='configurable-matrix']", 30); // stepKey: waitForVariationsGrid
		$I->comment("Entering Action Group [setFirstVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->fillField(".admin__field[data-index='configurable-matrix'] input[name='configurable-matrix[0][qty]']", "0"); // stepKey: fillVariationQuantitySetFirstVariationQuantity
		$I->comment("Exiting Action Group [setFirstVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->comment("Entering Action Group [setSecondVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->fillField(".admin__field[data-index='configurable-matrix'] input[name='configurable-matrix[1][qty]']", "1"); // stepKey: fillVariationQuantitySetSecondVariationQuantity
		$I->comment("Exiting Action Group [setSecondVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->comment("Entering Action Group [setThirdVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->fillField(".admin__field[data-index='configurable-matrix'] input[name='configurable-matrix[2][qty]']", "1"); // stepKey: fillVariationQuantitySetThirdVariationQuantity
		$I->comment("Exiting Action Group [setThirdVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->comment("Entering Action Group [setFourthVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->fillField(".admin__field[data-index='configurable-matrix'] input[name='configurable-matrix[3][qty]']", "1"); // stepKey: fillVariationQuantitySetFourthVariationQuantity
		$I->comment("Exiting Action Group [setFourthVariationQuantity] AdminChangeConfigurableProductVariationQty");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveConfigurableProductActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveButtonSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonSaveConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveConfigurableProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveConfigurableProduct
		$I->seeInTitle("configurable" . msq("BaseConfigurableProduct")); // stepKey: seeProductNameInTitleSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveConfigurableProductActionGroup");
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSectionWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSectionHeader
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionHeaderWaitForPageLoad
		$grabUrlKey = $I->grabValueFrom("input[name='product[url_key]']"); // stepKey: grabUrlKey
		$I->amOnPage("{$grabUrlKey}.html"); // stepKey: amOnConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->waitForElementVisible("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createFirstAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", 30); // stepKey: waitForFirstSelect
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createFirstAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createFirstAttributeFirstOption', 'option[store_labels][0][label]', 'test')); // stepKey: selectFirstAttributeFirstOption
		$I->waitForElementVisible("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createSecondAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", 30); // stepKey: waitForSecondSelect
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createSecondAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createSecondAttributeSecondOption', 'option[store_labels][0][label]', 'test')); // stepKey: selectSecondAttributeSecondOption
	}
}
