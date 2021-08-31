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
 * @Title("MAGETWO-92424: Verify the default option value for product Status attribute is set correctly during product creation")
 * @Description("The default option value for product Status attribute is set correctly during product creation<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductStatusAttributeDisabledByDefaultTest.xml<br>")
 * @TestCaseId("MAGETWO-92424")
 * @group Catalog
 */
class AdminProductStatusAttributeDisabledByDefaultTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttribute
		$I->comment("Exiting Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid1
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGrid1WaitForPageLoad
		$I->fillField("#attributeGrid_filter_frontend_label", "Enable Product"); // stepKey: setAttributeLabel1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGrid1
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGrid1WaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRow1
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRow1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("[data-role='options-container'] tr:nth-of-type(1) input[name='default[]']"); // stepKey: resetOptionForStatusAttribute
		$I->click("#save"); // stepKey: saveAttribute1
		$I->waitForPageLoad(30); // stepKey: saveAttribute1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttribute1
		$I->comment("Entering Action Group [clearCache1] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache1
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache1
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache1
		$I->comment("Exiting Action Group [clearCache1] ClearCacheActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Create products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductStatusAttributeDisabledByDefaultTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttribute
		$I->comment("Exiting Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridWaitForPageLoad
		$I->fillField("#attributeGrid_filter_frontend_label", "Enable Product"); // stepKey: setAttributeLabel
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRow
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("[data-role='options-container'] tr:nth-of-type(2) input[name='default[]']"); // stepKey: chooseDisabledOptionForStatus
		$I->click("#save"); // stepKey: saveAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSave
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickOnAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickOnAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickOnAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductClickOnAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickOnAddSimpleProduct
		$I->comment("Exiting Action Group [clickOnAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->dontSeeCheckboxIsChecked("input[name='product[status]']"); // stepKey: dontSeeCheckboxEnableProductIsChecked
	}
}
