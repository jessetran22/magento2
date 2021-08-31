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
 * @Title("MC-11018: Delete Downloadable Product")
 * @Description("Admin should be able to delete a downloadable product<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminDeleteDownloadableProductTest.xml<br>")
 * @TestCaseId("MC-11018")
 * @group mtf_migrated
 */
class AdminDeleteDownloadableProductTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createDownloadableProduct", "hook", "DownloadableProductWithTwoLink", ["createCategory"], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->createEntity("addDownloadableLink2", "hook", "downloadableLink2", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Downloadable"})
	 * @Stories({"Downloadable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteDownloadableProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteDownloadableProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteDownloadableProductFilteredBySkuAndName
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteDownloadableProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteDownloadableProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createDownloadableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteDownloadableProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createDownloadableProduct', 'name', 'test')); // stepKey: fillProductNameFilterDeleteDownloadableProductFilteredBySkuAndName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteDownloadableProductFilteredBySkuAndNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createDownloadableProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteDownloadableProductFilteredBySkuAndName
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteDownloadableProductFilteredBySkuAndName
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteDownloadableProductFilteredBySkuAndName
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteDownloadableProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteDownloadableProductFilteredBySkuAndNameWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteDownloadableProductFilteredBySkuAndName
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteDownloadableProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteDownloadableProductFilteredBySkuAndNameWaitForPageLoad
		$I->comment("Exiting Action Group [deleteDownloadableProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->see("A total of 1 record(s) have been deleted.", ".message-success"); // stepKey: deleteMessage
		$I->comment("Verify product on Product Page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnDownloadableProductPage
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoops
		$I->comment("Search for the product by sku");
		$I->comment("Entering Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createDownloadableProduct', 'sku', 'test')); // stepKey: fillSearchFieldSearchByCreatedTerm
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonSearchByCreatedTermWaitForPageLoad
		$I->click("button.action.search"); // stepKey: clickSearchButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchByCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultsSearchByCreatedTerm
		$I->comment("Exiting Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->comment("Should not see any search results");
		$I->dontSee($I->retrieveEntityField('createDownloadableProduct', 'sku', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProduct
		$I->see("Your search returned no results.", "div.message div"); // stepKey: seeCantFindProductOneMessage
		$I->comment("Go to the category page that we created in the before block");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->comment("Should not see the product");
		$I->dontSee($I->retrieveEntityField('createDownloadableProduct', 'name', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProductInCategory
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeEmptyProductMessage
	}
}
