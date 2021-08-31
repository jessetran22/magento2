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
 * @Title("MC-28534: Product grid filtering by store view level attribute")
 * @Description("Verify that products grid can be filtered on all store view level by attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminFilterByNameByStoreViewOnProductGridTest.xml<br>")
 * @TestCaseId("MC-28534")
 * @group catalog
 */
class AdminFilterByNameByStoreViewOnProductGridTestCest
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
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct2
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
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->comment("Entering Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductsFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductsFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductsFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductsFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
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
	 * @Stories({"Filter products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminFilterByNameByStoreViewOnProductGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct1', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [switchToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchToDefaultStoreView
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchToDefaultStoreViewWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]"); // stepKey: clickStoreViewByNameSwitchToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToDefaultStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchToDefaultStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchToDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchToDefaultStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchToDefaultStoreView
		$I->see("Default Store View", ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchToDefaultStoreView
		$I->comment("Exiting Action Group [switchToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->click("input[name='use_default[name]']"); // stepKey: uncheckUseDefault
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createSimpleProduct2', 'name', 'test')); // stepKey: fillNewName
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterGridByName] FilterProductGridByName2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGridByName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGridByNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGridByName
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct2', 'name', 'test')); // stepKey: fillProductNameFilterFilterGridByName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGridByName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGridByNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGridByName
		$I->comment("Exiting Action Group [filterGridByName] FilterProductGridByName2ActionGroup");
		$I->seeElement("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test') . "']]"); // stepKey: seeProduct2InGrid
		$I->dontSeeElement("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test') . "']]"); // stepKey: dontSeeProduct1InGrid
	}
}
