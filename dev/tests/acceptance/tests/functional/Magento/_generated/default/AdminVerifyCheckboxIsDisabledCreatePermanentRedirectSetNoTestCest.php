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
 * @Title("MC-35589: Verify checkbox is disabled 'Create Permanent Redirect' set 'No'")
 * @Description("Verify checkbox is disabled 'Create Permanent Redirect' set 'No' on category and product edit page.<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/AdminVerifyCheckboxIsDisabledCreatePermanentRedirectSetNoTest.xml<br>")
 * @TestCaseId("MC-35589")
 */
class AdminVerifyCheckboxIsDisabledCreatePermanentRedirectSetNoTestCest
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
		$enableCreatePermanentRedirect = $I->magentoCLI("config:set catalog/seo/save_rewrites_history 0", 60); // stepKey: enableCreatePermanentRedirect
		$I->comment($enableCreatePermanentRedirect);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createDefaultCategory"], []); // stepKey: createSimpleProduct
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteDefaultCategory
		$disableCreatePermanentRedirect = $I->magentoCLI("config:set catalog/seo/save_rewrites_history 1", 60); // stepKey: disableCreatePermanentRedirect
		$I->comment($disableCreatePermanentRedirect);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"CatalogUrlRewrite"})
	 * @Stories({"Url rewrites"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyCheckboxIsDisabledCreatePermanentRedirectSetNoTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -120); // stepKey: scrollToSeoSection
		$I->waitForPageLoad(30); // stepKey: scrollToSeoSectionWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$grabValue = $I->grabValueFrom("input[name='product[url_key_create_redirect]']"); // stepKey: grabValue
		$I->assertEmpty("$grabValue"); // stepKey: checkUrlKeyRedirectCheckbox
		$I->comment("Entering Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createDefaultCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenCreatedSubCategory
		$I->comment("Exiting Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", 0, -120); // stepKey: scrollToSeoSection1
		$I->waitForPageLoad(30); // stepKey: scrollToSeoSection1WaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSeoSection1
		$I->waitForPageLoad(30); // stepKey: openSeoSection1WaitForPageLoad
		$grabValue1 = $I->grabValueFrom("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: grabValue1
		$I->assertEmpty("$grabValue1"); // stepKey: checkUrlKeyRedirectCheckbox1
	}
}
