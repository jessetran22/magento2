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
 * @Title("MC-11015: Delete Product with Custom Option")
 * @Description("Admin should be able to delete a product with custom option<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteProductWithCustomOptionTest.xml<br>")
 * @TestCaseId("MC-11015")
 * @group mtf_migrated
 */
class AdminDeleteProductWithCustomOptionTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->updateEntity("createSimpleProduct", "hook", "productWithOptions2",[]); // stepKey: updateProductWithCustomOption
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Catalog"})
	 * @Stories({"Delete products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteProductWithCustomOptionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSimpleProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteSimpleProductFilteredBySkuAndName
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteSimpleProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSimpleProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteSimpleProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillProductNameFilterDeleteSimpleProductFilteredBySkuAndName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSimpleProductFilteredBySkuAndNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSimpleProductFilteredBySkuAndName
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSimpleProductFilteredBySkuAndName
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSimpleProductFilteredBySkuAndName
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSimpleProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSimpleProductFilteredBySkuAndNameWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteSimpleProductFilteredBySkuAndName
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteSimpleProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSimpleProductFilteredBySkuAndNameWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSimpleProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->see("A total of 1 record(s) have been deleted.", ".message-success"); // stepKey: deleteMessage
		$I->comment("Verify product on product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->see("Whoops, our bad...", ".base"); // stepKey: seeWhoops
		$I->comment("Search for the product by sku");
		$I->comment("Entering Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSearchFieldSearchByCreatedTerm
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonSearchByCreatedTermWaitForPageLoad
		$I->click("button.action.search"); // stepKey: clickSearchButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchByCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultsSearchByCreatedTerm
		$I->comment("Exiting Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->comment("Should not see any search results");
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProduct
		$I->see("Your search returned no results.", "div.message div"); // stepKey: seeCantFindProductOneMessage
		$I->comment("Go to the category page that we created in the before block");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->comment("Should not see the product");
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), "#maincontent .column.main"); // stepKey: dontSeeProductInCategory
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeEmptyProductMessage
	}
}
