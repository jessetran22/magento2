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
 * @Title("MC-11019: Delete Grouped Product")
 * @Description("Admin should be able to delete a grouped product<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminDeleteGroupedProductTest.xml<br>")
 * @TestCaseId("MC-11019")
 * @group mtf_migrated
 */
class AdminDeleteGroupedProductTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "ApiProductWithDescription", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct2", ["createCategory"], []); // stepKey: createGroupedProduct
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createSimpleProduct"], []); // stepKey: addProductOne
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"Delete product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteGroupedProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteGroupedProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteGroupedProductFilteredBySkuAndName
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteGroupedProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteGroupedProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createGroupedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteGroupedProductFilteredBySkuAndName
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createGroupedProduct', 'name', 'test')); // stepKey: fillProductNameFilterDeleteGroupedProductFilteredBySkuAndName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteGroupedProductFilteredBySkuAndNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createGroupedProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteGroupedProductFilteredBySkuAndName
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteGroupedProductFilteredBySkuAndName
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteGroupedProductFilteredBySkuAndName
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteGroupedProductFilteredBySkuAndNameWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteGroupedProductFilteredBySkuAndNameWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteGroupedProductFilteredBySkuAndName
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteGroupedProductFilteredBySkuAndName
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteGroupedProductFilteredBySkuAndNameWaitForPageLoad
		$I->comment("Exiting Action Group [deleteGroupedProductFilteredBySkuAndName] DeleteProductUsingProductGridActionGroup");
		$I->deleteEntity("createSimpleProduct", "test"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [deleteMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleDeleteMessage
		$I->see("A total of 1 record(s) have been deleted.", "#messages div.message-success"); // stepKey: verifyMessageDeleteMessage
		$I->comment("Exiting Action Group [deleteMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Verify product on Product Page");
		$I->comment("Entering Action Group [amOnGroupedProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAmOnGroupedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedAmOnGroupedProductPage
		$I->comment("Exiting Action Group [amOnGroupedProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [seeWhoops] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->see("Whoops, our bad...", ".base"); // stepKey: assert404PageSeeWhoops
		$I->dontSee($I->retrieveEntityField('createGroupedProduct', 'name', 'test'), ".base"); // stepKey: dontSeeProductNameSeeWhoops
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkProductUrlSeeWhoops
		$I->comment("Exiting Action Group [seeWhoops] StorefrontAssertPageNotFoundErrorOnProductDetailPageActionGroup");
		$I->comment("Search for the product by sku");
		$I->comment("Entering Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createGroupedProduct', 'sku', 'test')); // stepKey: fillSearchFieldSearchByCreatedTerm
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonSearchByCreatedTermWaitForPageLoad
		$I->click("button.action.search"); // stepKey: clickSearchButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchByCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultsSearchByCreatedTerm
		$I->comment("Exiting Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->comment("Should not see any search results");
		$I->comment("Entering Action Group [dontSeeProduct] AssertStorefrontProductNotOnSearchPageActionGroup");
		$I->dontSee($I->retrieveEntityField('createGroupedProduct', 'sku', 'test'), "#maincontent .column.main"); // stepKey: doNotSeeProductDontSeeProduct
		$I->comment("Exiting Action Group [dontSeeProduct] AssertStorefrontProductNotOnSearchPageActionGroup");
		$I->comment("Entering Action Group [seeCantFindProductOneMessage] AssertStorefrontNoResultsMessageOnSearchPageActionGroup");
		$I->see("Your search returned no results.", "div.message.notice div"); // stepKey: seeNoSearchResultsMessageSeeCantFindProductOneMessage
		$I->comment("Exiting Action Group [seeCantFindProductOneMessage] AssertStorefrontNoResultsMessageOnSearchPageActionGroup");
		$I->comment("Go to the category page that we created in the before block");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [dontSeeProductInCategory] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: navigateToCategoryPageDontSeeProductInCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadDontSeeProductInCategory
		$I->dontSee($I->retrieveEntityField('createGroupedProduct', 'name', 'test'), ".product-item-name"); // stepKey: assertProductIsNotPresentDontSeeProductInCategory
		$I->comment("Exiting Action Group [dontSeeProductInCategory] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [seeEmptyProductMessage] AssertStorefrontNoProductsFoundActionGroup");
		$I->see("We can't find products matching the selection."); // stepKey: seeEmptyNoticeSeeEmptyProductMessage
		$I->comment("Exiting Action Group [seeEmptyProductMessage] AssertStorefrontNoProductsFoundActionGroup");
	}
}
