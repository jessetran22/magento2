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
 * @Title("MC-26056: Delete Bundle Dynamic Product")
 * @Description("Admin should be able to delete a bundle dynamic product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminDeleteBundleDynamicPriceProductTest.xml<br>")
 * @TestCaseId("MC-26056")
 * @group mtf_migrated
 * @group bundle
 */
class AdminDeleteBundleDynamicPriceProductTestCest
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
		$I->comment("Create category and simple product");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Create bundle product");
		$I->createEntity("createDynamicBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createDynamicBundleProduct
		$I->createEntity("bundleOption", "hook", "DropDownBundleOption", ["createDynamicBundleProduct"], []); // stepKey: bundleOption
		$I->createEntity("createNewBundleLink", "hook", "ApiBundleLink", ["createDynamicBundleProduct", "bundleOption", "createSimpleProduct"], []); // stepKey: createNewBundleLink
		$I->comment("TODO: Remove this action when MC-37719 will be fixed");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"Bundle"})
	 * @Stories({"Delete products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteBundleDynamicPriceProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteBundleProductBySku] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundleProductBySku
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteBundleProductBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteBundleProductBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundleProductBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteBundleProductBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundleProductBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleProductBySkuWaitForPageLoad
		$I->see($I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundleProductBySku
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundleProductBySku
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundleProductBySku
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundleProductBySku
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleProductBySkuWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundleProductBySku
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleProductBySkuWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteBundleProductBySku
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteBundleProductBySkuWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteBundleProductBySku
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleProductBySkuWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteBundleProductBySku
		$I->comment("Exiting Action Group [deleteBundleProductBySku] DeleteProductBySkuActionGroup");
		$I->comment("Verify product on Product Page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDynamicBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openBundleProductPage
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoopsMessage
		$I->comment("Search for the product by sku");
		$I->comment("Entering Action Group [searchBySku] StoreFrontQuickSearchActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test')); // stepKey: fillSearchFieldSearchBySku
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonSearchBySku
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonSearchBySkuWaitForPageLoad
		$I->click("button.action.search"); // stepKey: clickSearchButtonSearchBySku
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchBySkuWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultsSearchBySku
		$I->comment("Exiting Action Group [searchBySku] StoreFrontQuickSearchActionGroup");
		$I->comment("Should not see bundle product");
		$I->dontSee($I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProduct
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->comment("Should not see any products in category");
		$I->dontSee($I->retrieveEntityField('createDynamicBundleProduct', 'name', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProductInCategory
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeEmptyProductMessage
	}
}
