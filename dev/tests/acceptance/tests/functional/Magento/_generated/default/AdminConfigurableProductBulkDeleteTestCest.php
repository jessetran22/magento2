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
 * @Title("MC-99: admin should be able to mass delete configurable products")
 * @Description("admin should be able to mass delete configurable products<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductDeleteTest/AdminConfigurableProductBulkDeleteTest.xml<br>")
 * @TestCaseId("MC-99")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductBulkDeleteTestCest
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
		$I->comment("TODO: Parts of this should be converted to an actionGroup once MQE-993 is fixed.");
		$I->comment("Create shared category and attribute");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create first of three configurable products");
		$I->createEntity("createProduct1", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct1
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption1", "hook", "ConfigurableProductTwoOptions", ["createProduct1", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption1
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createProduct1", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createProduct1", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Create second configurable product");
		$I->createEntity("createProduct2", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct2
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct3
		$I->createEntity("createConfigChildProduct4", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct4
		$I->createEntity("createConfigProductOption2", "hook", "ConfigurableProductTwoOptions", ["createProduct2", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption2
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createProduct2", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
		$I->createEntity("createConfigProductAddChild4", "hook", "ConfigurableProductAddChild", ["createProduct2", "createConfigChildProduct4"], []); // stepKey: createConfigProductAddChild4
		$I->comment("Create third configurable product");
		$I->createEntity("createProduct3", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createProduct3
		$I->createEntity("createConfigChildProduct5", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct5
		$I->createEntity("createConfigChildProduct6", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct6
		$I->createEntity("createConfigProductOption3", "hook", "ConfigurableProductTwoOptions", ["createProduct3", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption3
		$I->createEntity("createConfigProductAddChild5", "hook", "ConfigurableProductAddChild", ["createProduct3", "createConfigChildProduct5"], []); // stepKey: createConfigProductAddChild5
		$I->createEntity("createConfigProductAddChild6", "hook", "ConfigurableProductAddChild", ["createProduct3", "createConfigChildProduct6"], []); // stepKey: createConfigProductAddChild6
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigChildProduct4", "hook"); // stepKey: deleteConfigChildProduct4
		$I->deleteEntity("createConfigChildProduct5", "hook"); // stepKey: deleteConfigChildProduct5
		$I->deleteEntity("createConfigChildProduct6", "hook"); // stepKey: deleteConfigChildProduct6
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create, Read, Update, Delete"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductBulkDeleteTest(AcceptanceTester $I)
	{
		$I->comment("Search for prefix of the 3 products we created via api");
		$I->comment("Entering Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductList
		$I->comment("Exiting Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clearAll
		$I->waitForPageLoad(30); // stepKey: clearAllWaitForPageLoad
		$I->comment("Entering Action Group [searchForProduct] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchForProductWaitForPageLoad
		$I->fillField("input#fulltext", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillKeywordSearchFieldSearchForProduct
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchForProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchForProduct
		$I->comment("Exiting Action Group [searchForProduct] SearchProductGridByKeywordActionGroup");
		$I->comment("Select all, then delete");
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdown
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGrid
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdown
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteAction
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModal
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDelete
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteWaitForPageLoad
		$I->comment("Should not see the records in the admin panel");
		$I->see("A total of 3 record(s) have been deleted.", ".message.message-success.success"); // stepKey: seeSuccessMsg
		$I->seeNumberOfElements("table.data-grid tr.data-row", "0"); // stepKey: seeNoResults
		$I->comment("after delete, assert product pages are 404");
		$I->amOnPage($I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: gotoStorefront1
		$I->waitForPageLoad(30); // stepKey: waitForProduct1
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoops1
		$I->dontSee($I->retrieveEntityField('createProduct1', 'name', 'test'), ".base"); // stepKey: dontSeeProduct1
		$I->amOnPage($I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: gotoStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForProduct2
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoops2
		$I->dontSee($I->retrieveEntityField('createProduct1', 'name', 'test'), ".base"); // stepKey: dontSeeProduct2
		$I->amOnPage($I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: gotoStorefront3
		$I->waitForPageLoad(30); // stepKey: waitForProduct3
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoops3
		$I->dontSee($I->retrieveEntityField('createProduct1', 'name', 'test'), ".base"); // stepKey: dontSeeProduct3
	}
}
