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
 * @group wishlist
 * @Title("N/a: When user tries to set the Email Text Length Limit higher then 10,000 then validation message occurs")
 * @Description("When user tries to set the Email Text Length Limit higher then 10,000 then validation message occurs<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/AdminCustomerWishListShareOptionsInputValidationTest.xml<br>")
 * @TestCaseId("N/a")
 */
class AdminCustomerWishListShareOptionsInputValidationTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [rollbackEmailTextLengthLimit] setEmailTextLengthLimitActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/wishlist/"); // stepKey: navigateToWishListConfigurationPageRollbackEmailTextLengthLimit
		$I->conditionalClick("#wishlist_email-head", "#wishlist_email-head.open", false); // stepKey: expandTabInNotAlreadyExpandedRollbackEmailTextLengthLimit
		$I->uncheckOption("#wishlist_email_text_limit_inherit"); // stepKey: uncheckUseSystemValueForWishListEmailTextLimitRollbackEmailTextLengthLimit
		$I->fillField("#wishlist_email_text_limit", "255"); // stepKey: enterWishListTextLengthLimitRollbackEmailTextLengthLimit
		$I->click("#save"); // stepKey: tryToSaveWishListConfigRollbackEmailTextLengthLimit
		$I->waitForPageLoad(30); // stepKey: tryToSaveWishListConfigRollbackEmailTextLengthLimitWaitForPageLoad
		$I->comment("Exiting Action Group [rollbackEmailTextLengthLimit] setEmailTextLengthLimitActionGroup");
		$I->checkOption("#wishlist_email_text_limit_inherit"); // stepKey: checkUseSystemValueForWishListEmailTextLimit
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Wishlist"})
	 * @Stories({"MAGETWO-8709"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCustomerWishListShareOptionsInputValidationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [setEmailTextLengthLimitToMin] setEmailTextLengthLimitActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/wishlist/"); // stepKey: navigateToWishListConfigurationPageSetEmailTextLengthLimitToMin
		$I->conditionalClick("#wishlist_email-head", "#wishlist_email-head.open", false); // stepKey: expandTabInNotAlreadyExpandedSetEmailTextLengthLimitToMin
		$I->uncheckOption("#wishlist_email_text_limit_inherit"); // stepKey: uncheckUseSystemValueForWishListEmailTextLimitSetEmailTextLengthLimitToMin
		$I->fillField("#wishlist_email_text_limit", "1"); // stepKey: enterWishListTextLengthLimitSetEmailTextLengthLimitToMin
		$I->click("#save"); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToMin
		$I->waitForPageLoad(30); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToMinWaitForPageLoad
		$I->comment("Exiting Action Group [setEmailTextLengthLimitToMin] setEmailTextLengthLimitActionGroup");
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageForMinimum
		$minimumWishListTextLengthLimit = $I->grabValueFrom("#wishlist_email_text_limit"); // stepKey: minimumWishListTextLengthLimit
		$I->assertEquals("1", $minimumWishListTextLengthLimit); // stepKey: AssertMinimumTextLengthLimitIsApplied
		$I->comment("Entering Action Group [setEmailTextLengthLimitToMax] setEmailTextLengthLimitActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/wishlist/"); // stepKey: navigateToWishListConfigurationPageSetEmailTextLengthLimitToMax
		$I->conditionalClick("#wishlist_email-head", "#wishlist_email-head.open", false); // stepKey: expandTabInNotAlreadyExpandedSetEmailTextLengthLimitToMax
		$I->uncheckOption("#wishlist_email_text_limit_inherit"); // stepKey: uncheckUseSystemValueForWishListEmailTextLimitSetEmailTextLengthLimitToMax
		$I->fillField("#wishlist_email_text_limit", "10000"); // stepKey: enterWishListTextLengthLimitSetEmailTextLengthLimitToMax
		$I->click("#save"); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToMax
		$I->waitForPageLoad(30); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToMaxWaitForPageLoad
		$I->comment("Exiting Action Group [setEmailTextLengthLimitToMax] setEmailTextLengthLimitActionGroup");
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageForMaximum
		$maximumWishListTextLengthLimit = $I->grabValueFrom("#wishlist_email_text_limit"); // stepKey: maximumWishListTextLengthLimit
		$I->assertEquals("10000", $maximumWishListTextLengthLimit); // stepKey: AssertMaximumTextLengthLimitIsApplied
		$I->comment("Entering Action Group [setEmailTextLengthLimitToLowerThanMin] setEmailTextLengthLimitActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/wishlist/"); // stepKey: navigateToWishListConfigurationPageSetEmailTextLengthLimitToLowerThanMin
		$I->conditionalClick("#wishlist_email-head", "#wishlist_email-head.open", false); // stepKey: expandTabInNotAlreadyExpandedSetEmailTextLengthLimitToLowerThanMin
		$I->uncheckOption("#wishlist_email_text_limit_inherit"); // stepKey: uncheckUseSystemValueForWishListEmailTextLimitSetEmailTextLengthLimitToLowerThanMin
		$I->fillField("#wishlist_email_text_limit", "0"); // stepKey: enterWishListTextLengthLimitSetEmailTextLengthLimitToLowerThanMin
		$I->click("#save"); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToLowerThanMin
		$I->waitForPageLoad(30); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToLowerThanMinWaitForPageLoad
		$I->comment("Exiting Action Group [setEmailTextLengthLimitToLowerThanMin] setEmailTextLengthLimitActionGroup");
		$I->dontSee("You saved the configuration.", "#messages div.message-success"); // stepKey: dontSeeSuccessMessageForLowerThanMinimum
		$enterWishListTextLengthLimitLowerThanMinimum = $I->grabTextFrom("#wishlist_email_text_limit-error"); // stepKey: enterWishListTextLengthLimitLowerThanMinimum
		$I->assertEquals("The value is not within the specified range.", $enterWishListTextLengthLimitLowerThanMinimum); // stepKey: AssertTextLengthLimitIsNotAppliedWhenLowerThanMinimum
		$I->comment("Entering Action Group [setEmailTextLengthLimitToHigherThanMaximum] setEmailTextLengthLimitActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/wishlist/"); // stepKey: navigateToWishListConfigurationPageSetEmailTextLengthLimitToHigherThanMaximum
		$I->conditionalClick("#wishlist_email-head", "#wishlist_email-head.open", false); // stepKey: expandTabInNotAlreadyExpandedSetEmailTextLengthLimitToHigherThanMaximum
		$I->uncheckOption("#wishlist_email_text_limit_inherit"); // stepKey: uncheckUseSystemValueForWishListEmailTextLimitSetEmailTextLengthLimitToHigherThanMaximum
		$I->fillField("#wishlist_email_text_limit", "10001"); // stepKey: enterWishListTextLengthLimitSetEmailTextLengthLimitToHigherThanMaximum
		$I->click("#save"); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToHigherThanMaximum
		$I->waitForPageLoad(30); // stepKey: tryToSaveWishListConfigSetEmailTextLengthLimitToHigherThanMaximumWaitForPageLoad
		$I->comment("Exiting Action Group [setEmailTextLengthLimitToHigherThanMaximum] setEmailTextLengthLimitActionGroup");
		$I->dontSee("You saved the configuration.", "#messages div.message-success"); // stepKey: dontSeeSuccessMessageForHigherThanMaximum
		$enterWishListTextLengthLimitHigherThanMaximum = $I->grabTextFrom("#wishlist_email_text_limit-error"); // stepKey: enterWishListTextLengthLimitHigherThanMaximum
		$I->assertEquals("The value is not within the specified range.", $enterWishListTextLengthLimitHigherThanMaximum); // stepKey: AssertTextLengthLimitIsNotAppliedWhenHigherThanMaximum
	}
}
