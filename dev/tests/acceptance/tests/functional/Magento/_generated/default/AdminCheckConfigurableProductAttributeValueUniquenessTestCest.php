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
 * @Title("MC-17450: Attribute value validation (check for uniqueness) in configurable products")
 * @Description("Attribute value validation (check for uniqueness) in configurable products<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCheckConfigurableProductAttributeValueUniquenessTest.xml<br>")
 * @TestCaseId("MC-17450")
 * @group ConfigurableProduct
 */
class AdminCheckConfigurableProductAttributeValueUniquenessTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createProductAttribute", "hook", "dropdownProductAttribute", [], []); // stepKey: createProductAttribute
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [deleteConfigurableProductAndOptions] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteConfigurableProductAndOptions
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteConfigurableProductAndOptionsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProductAndOptions
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteConfigurableProductAndOptions
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createConfigProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteConfigurableProductAndOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductAndOptionsWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'hook'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProductAndOptions
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProductAndOptions
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProductAndOptions
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductAndOptionsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductAndOptionsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteConfigurableProductAndOptions
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProductAndOptions
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductAndOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteConfigurableProductAndOptions] DeleteProductUsingProductGridActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPage
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteAttribute
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckConfigurableProductAttributeValueUniquenessTest(AcceptanceTester $I)
	{
		$I->comment("Create configurable product");
		$I->comment("Create configurable product");
		$I->createEntity("createCategory", "test", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "test", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Go to created product page");
		$I->comment("Go to created product page");
		$I->comment("Entering Action Group [goToProductGrid] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductGrid
		$I->comment("Exiting Action Group [goToProductGrid] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [filterByName] FilterProductGridByName2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterByName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterByNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterByName
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: fillProductNameFilterFilterByName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterByName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterByNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterByName
		$I->comment("Exiting Action Group [filterByName] FilterProductGridByName2ActionGroup");
		$I->comment("Entering Action Group [clickOnProductName] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductName
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductName
		$I->comment("Exiting Action Group [clickOnProductName] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Create configurations for the product");
		$I->comment("Create configurations for the product");
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: expandConfigurationsTab1
		$I->waitForPageLoad(30); // stepKey: expandConfigurationsTab1WaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurations1
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurations1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSelectAttributesPage1
		$I->comment("Entering Action Group [selectCreatedAttributeAndCreateOptions] SelectCreatedAttributeAndCreateTwoOptionsActionGroup");
		$I->comment("Create new attribute");
		$I->comment("Find created below attribute and add option; save attribute");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersSelectCreatedAttributeAndCreateOptions
		$I->fillField(".admin__control-text[name='attribute_code']", "attribute" . msq("dropdownProductAttribute")); // stepKey: fillFilterAttributeCodeFieldSelectCreatedAttributeAndCreateOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxSelectCreatedAttributeAndCreateOptions
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateFirstNewValueSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnCreateFirstNewValueSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "option1" . msq("productAttributeOption1")); // stepKey: fillFieldForNewFirstOptionSelectCreatedAttributeAndCreateOptions
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttributeSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttributeSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateSecondNewValueSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnCreateSecondNewValueSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "option1" . msq("productAttributeOption1")); // stepKey: fillFieldForNewSecondOptionSelectCreatedAttributeAndCreateOptions
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveAttributeSelectCreatedAttributeAndCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeSelectCreatedAttributeAndCreateOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [selectCreatedAttributeAndCreateOptions] SelectCreatedAttributeAndCreateTwoOptionsActionGroup");
		$I->comment("Check that system does not allow to save 2 options with same name");
		$I->comment("Check that system does not allow to save 2 options with same name");
		$I->seeElement("//li[@data-attribute-option-title='']/div[contains(@class,'admin__field admin__field-create-new _error')]"); // stepKey: seeThatOptionWithSameNameIsNotSaved
		$I->comment("Click next and assert error message");
		$I->comment("Click next and assert error message");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNext
		$I->waitForPageLoad(30); // stepKey: clickNextWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForPageLoad
		$grabErrMsg = $I->grabTextFrom("//div[contains(@class,'attribute-entity-title-block')]/div[contains(@class,'attribute-entity-title')]"); // stepKey: grabErrMsg
		$I->see("The value of attribute \"$grabErrMsg\" must be unique"); // stepKey: verifyAttributesValueUniqueness
	}
}
